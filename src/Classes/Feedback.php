<?php


// TODO: Прибрати зайве з конструктора
// TODO: Виправити setName()
// TODO: Метод findAndSetEmail() -> setEmailByName()
// TODO: Оновити validateEmail()
// TODO: Оновити saveFeedback()
// TODO: Додати геттер для всіх фідбеків

class Feedback
{

    private string $name;
    private string $email;

    private string $message = "Everything was great, thank you! ";

  public array $users = [
        ['name' => 'Alex', 'email' => 'alex@example.com'],
        ['name' => 'Bob', 'email' => 'bob@example.com'],
        ['name' => 'Jim', 'email' => 'jim@example.com'],
        ['name' => 'Nina', 'email' => 'nina@example.com']
  ];

  private array $feedback ;

    /**
     * @param string $name
     * @param string $email
     * @param array|array[] $users
     * @param array $feedback
     */
    public function __construct(string $name, string $email, array $users, array $feedback)
    {
        $this->name = $name;
        $this->email = $email;
        $this->users = $users;
        $this->feedback = $feedback;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $nameOfUser): void
    {
        foreach ($this->users as $user) {
            if ($user['name'] === $name) {
                $this->name = $user['name'];
                return;
            }
        }
        echo "Error: Name not found for user $nameToFind!";
    }



    /**
     * @param string $nameToFind
     * @return void
     */
    public function findAndSetEmail(string $nameToFind): void {
        foreach ($this->users as $user) {
            if ($user['name'] === $nameToFind) {
                $this->email = $user['email'];
                return;
            }
        }
        echo "Error: Email not found for user $nameToFind!";
    }

    public function saveFeedback(string $data, string $name,  callable $callback): void
    {
        if ($callback === true){
            $this->feedback[$name] = $data;
            return;
        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $input
     * @return string
     */
    public function formatText(string $input): string
    {
        $input = trim($input);

        return strtolower($input);
    }

    public function validateEmail( string $emailToValidate): bool
    {
        foreach ($this->users as $email) {
            if ($email['email'] !== $emailToValidate) {
                print("Error: You cannot leave a review, your email was not found!");
                return false;
            }
        }
        return true;

    }



}