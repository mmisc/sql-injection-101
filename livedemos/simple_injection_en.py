#!/bin/python3

def print_hello():
    name = input("What is your name? ")

    print(f"Your name: \"{name}\"")
    print()

    message = f"Hello {name}, have a nice day!"
    print(message)


if __name__ == '__main__':
    print_hello()
