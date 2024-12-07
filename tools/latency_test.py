import csv
import hashlib
import json
import matplotlib.pyplot as plt
import os
import requests
import sys
import time
import urllib3

from datetime import datetime

urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

if len(sys.argv) != 3:
    print("latency_test.py <API-Key> <App-ID>")
    exit(0)

api_key = sys.argv[1]
app_id = sys.argv[2]

output_filename = "latency_results.csv"
graph_filename = "latency_graph.png"

headers = {
    "QLBase-API-Key": api_key,
    "QLBase-App-ID": app_id
}

actions = [
    "handshake",

    "auth_delete_by_username", "auth_create_user",
    "auth_get_by_username", "auth_get_by_email",
    "auth_disable_user", "auth_is_enabled",
    "auth_enable_user", "auth_login_username",
    "auth_fetch_all",

    "sms_verification", "sms_fetch_all",

    "id_delete_by_anon_id", "id_create_live_timestamp",
    "id_get_by_user_id", "id_fetch_all",

    "track_delete_by_anon_id", "track_create_live_timestamp",
    "track_get_by_user_id", "track_get_by_event",
    "track_fetch_all",

    "page_delete_by_anon_id", "page_create_live_timestamp",
    "page_get_by_user_id", "page_get_by_category",
    "page_get_by_name", "page_fetch_all",

    "db_delete", "db_create", "db_read", "db_write",
    "db_get_by_name", "db_set_mode", "db_get_mode",
    "db_fetch_all",

    "cdp_expire_all"
]
results = []

password = hashlib.sha512("test".encode()).hexdigest()
body = {
    "handshake": {},
    "auth_delete_by_username": {
        "username": "testuser"
    },
    "auth_create_user": {
        "username": "testuser",
        "email": "test@user.com",
        "password": password,
        "enabled": "1"
    },
    "auth_get_by_username": {
        "username": "testuser"
    },
    "auth_get_by_email": {
        "email": "test@user.com"
    },
    "auth_disable_user": {
        "username": "testuser"
    },
    "auth_is_enabled": {
        "username": "testuser"
    },
    "auth_enable_user": {
        "username": "testuser"
    },
    "auth_login_username": {
        "username": "testuser",
        "password": password
    },
    "auth_fetch_all": {},
    "sms_verification": {
        "recipient": "+639999999999",
        "support": "test@example.com"
    },
    "sms_fetch_all": {},
    "id_delete_by_anon_id" : {
        "tracker": "trackeridex",
        "anon_id": "anonidex"
    },
    "id_create_live_timestamp" : {
        "tracker": "trackeridex",
        "anon_id": "anonidex",
        "user_id": "useridex",
        "payload": "e30="
    },
    "id_get_by_user_id": {
        "user_id": "useridex"
    },
    "id_fetch_all": {},
    "track_delete_by_anon_id": {
        "tracker": "trackeridex",
        "anon_id": "anonidex"
    },
    "track_create_live_timestamp": {
        "tracker": "trackeridex",
        "anon_id": "anonidex",
        "user_id": "useridex",
        "event": "eventidex",
        "payload": "e30="
    },
    "track_get_by_user_id": {
        "user_id": "useridex"
    },
    "track_get_by_event": {
        "user_id": "useridex",
        "event": "eventidex"
    },
    "track_fetch_all": {},
    "page_delete_by_anon_id": {
        "tracker": "trackeridex",
        "anon_id": "anonidex"
    },
    "page_create_live_timestamp": {
        "tracker": "trackeridex",
        "anon_id": "anonidex",
        "user_id": "useridex",
        "name": "nameidex",
        "category": "categidex",
        "payload": "e30="
    },
    "page_get_by_user_id": {
        "user_id": "useridex"
    },
    "page_get_by_category": {
        "category": "categidex"
    },
    "page_get_by_name": {
        "name": "nameidex"
    },
    "page_fetch_all": {},
    "db_delete": {
        "name": "testdb"
    },
    "db_create": {
        "name": "testdb",
        "mode": "rw",
        "content": "e30="
    },
    "db_read": {
        "name": "testdb"
    },
    "db_write": {
        "name": "testdb",
        "content": "e30="
    },
    "db_get_by_name": {
        "name": "testdb"
    },
    "db_set_mode": {
        "name": "testdb",
        "mode": "w"
    },
    "db_get_mode": {
        "name": "testdb"
    },
    "db_fetch_all": {},
    "cdp_expire_all": {}
}

for action in actions:
    url = f"https://localhost/qlbase/api/index.php?action={action}"

    try:
        start_time = time.time()
        response = requests.post(url, headers=headers, json=body[action], verify=False)
        response.raise_for_status()

        elapsed_time = int((time.time() - start_time) * 1000)
        timestamp = int(datetime.now().timestamp())

        print(f"Action: {action}\r\n\tResults: {json.dumps(response.json())}")
        results.append((action, timestamp, elapsed_time))

    except requests.exceptions.RequestException as e:
        print(f"Error for action '{action}': {e}")
        continue

if(os.path.exists(output_filename)):
    os.remove(output_filename)

with open(output_filename, "w", newline="") as csvfile:
    writer = csv.writer(csvfile)
    writer.writerow(["action", "timestamp", "ellapsed_time"])
    writer.writerows(results)

print(f"\r\nResults saved to {output_filename}")

actions_list = [result[0] for result in results]
elapsed_times = [result[2] for result in results]

plt.figure(figsize=(10, 6))
plt.barh(actions_list, elapsed_times, color='skyblue')
plt.xlabel("Elapsed Time (ms)")
plt.ylabel("Action")
plt.title("API Latency for Different Actions")
plt.tight_layout()
plt.savefig(graph_filename)

print(f"Graph saved as {graph_filename}")