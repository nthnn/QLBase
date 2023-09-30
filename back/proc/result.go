package proc

import "fmt"

func showFailedResponse(errorMessage string) {
	fmt.Println("{\"result\": \"0\", \"message\": \"" + errorMessage + "\"}")
}

func showResult(value string, message string) {
	fmt.Println("{\"result\": \"1\", \"message\": \"" +
		message + "\", \"value\": \"" +
		value + "\"}")
}
