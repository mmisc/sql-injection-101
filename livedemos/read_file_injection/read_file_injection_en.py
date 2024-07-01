#!/bin/python3

def print_personal_note():
    name = input("What is your name? ")

    print(f"Your name: \'{name}\'")

    filename = f"./notes/{name}.txt"
    print(f"Reading file: {filename}")

    print()
    print("Your personal note's content: ")

    with open(filename, "r") as f:
        print(f.read())


if __name__ == '__main__':
    print_personal_note()
