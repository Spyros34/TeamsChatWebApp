import os
basedir = os.path.abspath(os.path.dirname(__file__))

class Config:
    SECRET_KEY = 'vwB8Q~G-tJGrUjIQ_E6MaOGLNF2YrRcjj9fxbbZW'
    SESSION_TYPE = 'filesystem'
    CLIENT_ID = 'aaedd656-9a56-4cea-8e3a-e6309c940387'
    CLIENT_SECRET = 'vwB8Q~G-tJGrUjIQ_E6MaOGLNF2YrRcjj9fxbbZW'
    AUTHORITY = 'https://login.microsoftonline.com/common'
    REDIRECT_PATH = '/getAToken'
    SCOPE = ['User.Read.All']
    SESSION_FILE_DIR = os.path.join(basedir, 'flask_session')
    SESSION_PERMANENT = False
    SESSION_USE_SIGNER = True
    SESSION_KEY_PREFIX = 'msal_session:'
    WEB_REDIRECT_PATH = '/getAToken'
    SPA_REDIRECT_PATH = '/spaRedirect'
    SCOPE = ['User.Read', 'User.ReadBasic.All', 'User.Read.All']
    ENDPOINT = 'https://graph.microsoft.com/v1.0/users'
    WEB_REDIRECT_URI = 'http://localhost:5002/getAToken'
    SPA_REDIRECT_URI = 'http://localhost:5002/spaRedirect'
    TENANT_ID = '49eed7cb-3d3f-407b-bad5-26bff43d0215'