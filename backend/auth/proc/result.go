package proc

import "fmt"

func ShowSuccessResponse() {
	fmt.Println("{\"result\": \"1\"}")
}

func ShowFailedResponse(errorMessage string) {
	fmt.Println("{\"result\": \"0\", \"message\": \"" + errorMessage + "\"}")
}

func ShowResult(value string, message string) {
	fmt.Println("{\"result\": \"1\", \"message\": \"" +
		message + "\", \"value\": \"" +
		value + "\"}")
}
