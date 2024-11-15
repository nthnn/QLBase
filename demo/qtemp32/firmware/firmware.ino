/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

#include <ArduinoJson.h>
#include <base64.h>
#include <DFRobot_DHT11.h>
#include <dynaconfig.h>
#include <HTTPClient.h>
#include <WiFi.h>

#define DHT11_PIN 5

// These are the localized version of the app
// key and ID on the development environment.
const char* serverUrl = "http://192.168.100.122/qlbase/api/index.php?action=track_create_live_timestamp";
const char* apiKey = "qba_8925a3c887_5f663b70";
const char* appId = "3871-c096-107c-94a0";

DFRobot_DHT11 DHT;
String anonId, userId;

String generateRandomString() {
    const char characters[] = "abcdefghijklmnopqrstuvwxyz";
    const int charactersLength = sizeof(characters) - 1;

    String result = "";
    for(int i = 0; i < 8; i++)
        result += characters[random(0, charactersLength)];
    return result;
}

void setup() {
    Serial.begin(115200);

    DynaConfig dynaConfig("QTemp32");
    dynaConfig.checkWiFiConfig();

    WiFi.mode(WIFI_STA);
    WiFi.begin(
        dynaConfig.getConfigSSID(),
        dynaConfig.getConfigPasskey()
    );
    dynaConfig.close();

    Serial.println("Connecting");
    while(WiFi.status() != WL_CONNECTED) {
        Serial.print(".");
        delay(100);
    }

    Serial.println("\nConnected to the WiFi network");
    Serial.print("Local ESP32 IP: ");
    Serial.println(WiFi.localIP());

    anonId = generateRandomString(),
    userId = generateRandomString();
}

void loop() {
    String tracker = generateRandomString();
    DHT.read(DHT11_PIN);

    DynamicJsonDocument jsonData(256);
    jsonData["temp"] = DHT.temperature;
    jsonData["humid"] = DHT.humidity;

    String dataString;
    serializeJson(jsonData, dataString);

    DynamicJsonDocument jsonDoc(256);
    jsonDoc["tracker"] = tracker;
    jsonDoc["anon_id"] = anonId;
    jsonDoc["user_id"] = userId;
    jsonDoc["event"] = "temprecevt";
    jsonDoc["payload"] = base64::encode(dataString);

    String requestBody;
    serializeJson(jsonDoc, requestBody);

    if(WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin(serverUrl);
        http.addHeader("Content-Type", "application/json");
        http.addHeader("QLBase-API-Key", apiKey);
        http.addHeader("QLBase-App-ID", appId);

        int httpResponseCode = http.POST(requestBody);
        if(httpResponseCode > 0) {
            Serial.printf("HTTP Response code: %d\n", httpResponseCode);

            String response = http.getString();
            Serial.println("Response:");
            Serial.println(response);
        }
        else Serial.printf(
            "Error in sending POST: %s\n",
            http.errorToString(httpResponseCode).c_str()
        );

        http.end();
    }

    delay(3000);
}
