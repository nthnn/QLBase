package main

import "encoding/base64"

func decodeBase64(text string) string {
	decoded, err := base64.StdEncoding.DecodeString(text)
	if err != nil {
		return "{}"
	}

	return string(decoded)
}
