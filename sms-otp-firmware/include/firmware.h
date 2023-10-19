#ifndef FIRMWARE_H
#define FIRMWARE_H

#include <SoftwareSerial.h>
#include <SIM900.h>

static SoftwareSerial shieldSerial(7, 8);
static SIM900 sim900(&shieldSerial);

void sendOTP(String number, String email, String otp);

#endif