# PHP Registration/Login Form

Registration and Login Form for school assignment using bcrypt algorithm with cost 8 to hash passwords

## **Link:** [Altervista website](https://alex0.altervista.org/test)

## **FRONT-END:**

**Made with Twig HTML and Bootstrap Framework 5.1**

## **BACK-END:**

**Made with PHP and Twig HTML Engine**

Twig allow to create template of html (see /templates) and to render them

## **DATABASE:**

**SQL query used to create the table of the form:**

```sql
CREATE TABLE IF NOT EXISTS form (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    newsletter BOOLEAN NOT NULL DEFAULT 0,
    preference VARCHAR(255) NOT NULL,
    billing_method VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;
```

**Queries are PREPARED STATEMENTS**

This prevents SQL injections from happening

## **To Run:**

**Requirements:**

- Composer ([install steps here](https://getcomposer.org/download/))

Then to install dependencies run:

```bash
    composer install
```

after that you can simply run a php server, for example using php command with the following values:

```bash
    php -S {address}:{port} -t ./src
```

## **TO DO:**

- **Add admin page**
- **Add deliverer page**

<footer>
<p style="float:left; width: 20%;">
    Copyright © Alexandru Nechita, 2022
</p>
<p style="float:left; width: 60%; text-align:center;">
<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png"/>
<br/>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>
</p>
<p style="float:left; width: 20%;">
alexandru.italia32@gmail.com
</p>
</footer>
