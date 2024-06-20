from flask import Flask, session, redirect, url_for, request, jsonify
from flask_session import Session
import msal
import requests
import os
import json
import http.client
import urllib3
import ssl

urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

app = Flask(__name__)
app.config.from_object('config.Config')
Session(app)

@app.route('/')
def index():
    if not session.get("user"):
        return redirect(url_for("login"))
    return "Hello, " + session["user"]["name"]

@app.route("/login")
def login():
    session["flow"] = _build_auth_code_flow(scopes=["User.Read"])
    return redirect(session["flow"]["auth_uri"])

@app.route(app.config["WEB_REDIRECT_PATH"])
def web_authorized():
    try:
        cache = _load_cache()
        result = _build_msal_app(cache=cache).acquire_token_by_auth_code_flow(session.get("flow", {}), request.args)
        if "error" in result:
            return f"Login failure: {result.get('error')}", 400
        session["user"] = result.get("id_token_claims")
        _save_cache(cache)
    except ValueError:
        pass
    return redirect(url_for("index"))

@app.route(app.config["SPA_REDIRECT_PATH"])
def spa_authorized():
    try:
        cache = _load_cache()
        result = _build_msal_app(cache=cache).acquire_token_by_auth_code_flow(session.get("flow", {}), request.args)
        if "error" in result:
            return f"Login failure: {result.get('error')}", 400
        session["user"] = result.get("id_token_claims")
        _save_cache(cache)
    except ValueError:
        pass
    return redirect(url_for("index"))

@app.route('/fetch-users', methods=['GET'])
def fetch_users():
    token = get_token()
    headers = {'Authorization': 'Bearer ' + token}
    
    url = "https://graph.microsoft.com/v1.0/users?$top=10"
    response = requests.get(url, headers=headers, verify=False)
    
    if response.status_code != 200:
        return jsonify({'error': 'Failed to fetch users'}), response.status_code

    users_data = response.json()
    return jsonify(users_data)
    if not session.get("user"):
        return redirect(url_for("login"))

    token = get_token()
    headers = {'Authorization': 'Bearer ' + token}

    # Fetch chats for the user
    chats_response = requests.get(f'https://graph.microsoft.com/v1.0/users/{user_id}/chats', headers=headers, verify=False)
    if chats_response.status_code != 200:
        return f"Error fetching chats: {chats_response.status_code}, {chats_response.text}", 500

    chats_data = chats_response.json()
    chats_list = chats_data.get('value', [])

    user_messages = []
    for chat in chats_list:
        chat_id = chat['id']
        messages_response = requests.get(f'https://graph.microsoft.com/v1.0/chats/{chat_id}/messages', headers=headers, verify=False)
        if messages_response.status_code == 200:
            messages_data = messages_response.json()
            messages_list = messages_data.get('value', [])
            for message in messages_list:
                if message['from']['user']['id'] == user_id:
                    user_messages.append(message['body']['content'])

    return {"messages": user_messages}

def _load_cache():
    cache = msal.SerializableTokenCache()
    if os.path.exists('token_cache.bin'):
        cache.deserialize(open('token_cache.bin', 'r').read())
    return cache

def _save_cache(cache):
    if cache.has_state_changed:
        open('token_cache.bin', 'w').write(cache.serialize())

def _build_msal_app(cache=None):
    return msal.ConfidentialClientApplication(
        app.config["CLIENT_ID"], authority=app.config["AUTHORITY"],
        client_credential=app.config["CLIENT_SECRET"], token_cache=cache)

def _build_auth_code_flow(scopes=None):
    return _build_msal_app().initiate_auth_code_flow(
        scopes or [],
        redirect_uri=app.config["WEB_REDIRECT_URI"])

def get_token():
    tenant_id = app.config["TENANT_ID"]
    client_secret = app.config["CLIENT_SECRET"]
    client_id = app.config["CLIENT_ID"]
    url = f"https://login.microsoftonline.com/{tenant_id}/oauth2/v2.0/token"
    headers = {'Content-Type': 'application/x-www-form-urlencoded'}
    body = {
        'grant_type': 'client_credentials',
        'client_id': client_id,
        'client_secret': client_secret,
        'scope': 'https://graph.microsoft.com/.default'
    }
    response = requests.post(url, headers=headers, data=body, verify=False)
    return response.json().get('access_token')

if __name__ == "__main__":
    app.run(host='localhost', port=5002)