#include <Arduino.h>
#include <firmware.h>

void setup() {
    Serial.begin(9600);
}

void loop() {
    if(Serial.available() > 0) {
        String serialString = Serial.readString();
        serialString.trim();

        int delim1 = serialString.indexOf(F(",")),
            delim2 = serialString.lastIndexOf(F(","));

        sendOTP(
            serialString.substring(0, delim1),
            serialString.substring(delim1 + 1, delim2),
            serialString.substring(delim2 + 1)
        );
    }
}
