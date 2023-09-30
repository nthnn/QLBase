package main

import (
	"fmt"
)

func main() {
	db_config := ConfigDB(DBUsername, DBPassword, DBName, DBServer, DBPort)
	db_conn, err := ConnectDB(db_config)

	if err != nil {
		fmt.Println(err)
		return
	}
	defer db_conn.Close()

	fmt.Println("Connected to MySQL database!")
}
