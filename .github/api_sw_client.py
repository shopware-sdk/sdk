import requests
import json

url = 'http://localhost:8000/api/oauth/token'
data = {
    'grant_type': 'password',
    'client_id': 'administration',
    'username': 'admin',
    'password': 'shopware'
}

response = requests.post(url, data=data)

response_dict = response.json()
access_token = response_dict['access_token']

url = 'http://localhost:8000/api/integration'
headers = {
    'Authorization': 'Bearer ' + access_token,
    'Content-Type': 'application/json'
}
data = {
    "accessKey" : "SWIAV3ZRRDLJZXVLU3N1N3ZVTG",
    "admin" : True,
    "id" : "e6c1525b0a2941ee901fe1c6ac713bf2",
    "label" : "Unit-Test-API",
    "secretAccessKey" : "eWd3Qnc1R0U3ZmFjUDFUaER0UmpmQ01FY1JCT3JzS3hvUHNyN0w"
}

requests.post(url, headers=headers, data=json.dumps(data))
