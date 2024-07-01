#!/bin/python3

def print_personal_note():
    name = input("Wie heißt du? ")

    print(f"Dein Name: \'{name}\'")

    filename = f"./notes/{name}.txt"
    print(f"Lese Datei: {filename}")

    print()
    print("Inhalt deiner persönlichen Notiz: ")

    with open(filename, "r") as f:
        print(f.read())


if __name__ == '__main__':
    print_personal_note()
