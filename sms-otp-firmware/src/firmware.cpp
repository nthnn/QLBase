#include <firmware.h>

void sendOTP(String number, String email, String otp) {
    Serial.println(sim900.sendSMS(number, "Your one-time password (OTP) is " + otp +
        ". Do not share your OTP to anyone. If you did not request for your OTP, report at " +
        email + ".\n\n(Sent via QLBase)") ? F("SENT") : F("ERR")
    );
}