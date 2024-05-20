#!/bin/python3

def print_hello():
    name = input("Wie heißt du? ")

    print(f"Dein Name: \"{name}\"")
    print()

    message = f"Hallo {name}, hab einen schönen Tag!"
    print(message)


if __name__ == '__main__':
    print_hello()
