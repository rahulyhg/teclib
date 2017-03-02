# teclib
A very easy to use library of different packages i.e sending emails both simple and smtp, making payments using paypal or other payment processors ...

## Tecmail
This is most easiest way to send html template based emails using either by simple mail function or using smtp (swiftmailer or phpmailer etc)

Tecmail is php library created for sending emails with an ease using html templates and placeholders:

 * You can create html templates and placeholders to send email
 * Supports attachments
 * You can choose to send email by core php mail function or smtp
 * For smtp it has PHPMailer and SwiftMailer as backend, you can choose any of these by simple config option, default is SwiftMailer

It is very easy to use, just create a mailer object and start sending emails.

### Installation
Git clone or download the repo in the directory where your mail sending script exists

### Configuration
open Tecnotch/Config.php and provide your smtp host name, user name and password 

```php
const SMTP_HOST = 'smtp.gmail.com'; //provide your smtp host here 
const SMTP_PORT = 465;		//provide smtp port
//const SMTP_PORT = 587;

 const SMTP_USER = 'your gmail id'; //provide your smpt username
 const SMTP_PASS = 'your gmail password'; //provide your smtp password

 const SMTP_MAILER = 'swiftmailer';  //configure smtp backend 

 //or you can use phpmailer as below
 //const SMTP_MAILER = 'phpmailer';
```

In your mail sending script just use
```php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch;
```
Create mailer object and start sending emails 

Please see **example.php** for usage

### Creating mailer object
Create mailer which uses core php mail() function
```php
$mailer = \Tecnotch\Factory::mailer('simple');
```

Create SMTP mailer
```php
$mailer = \Tecnotch\Factory::mailer('smtp');
//You can configure backend as phpmailer or swiftmailer in Tecnotch/Config.php) 
//Default: 
const SMTP_MAILER = 'swiftmailer'; 
//you can use phpmailer as below 
const SMTP_MAILER = 'phpmailer';
```

### Examples


#### Sending a simple email using native mail() function of php 

```php
$mailer = \Tecnotch\Factory::mailer('simple');
 
$mailer
	->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
	->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
	->setFrom(array("sender@example.com" => "Tecnotch"))
	->setSubject("Simple Email")
	->setBody("This is simple email without template using simple mail function ")
	->send();
```

#### Sending email based on html template and placeholders using native php mail() function 

```php
$mailer = \Tecnotch\Factory::mailer('simple');
//keep them in order as they are below
$placeholders = array(
	"[user_name]" => "John Doe"
);
$mailer
    ->setPlaceholders($placeholders)
    ->setTemplatePath(__DIR__ . '/html/email/en')
    ->setTemplate("sample.html")
    ->setTo(array("email1@example.com" => "Tofeeq Rehman"))
    ->setFrom(array("sender@example.com" => "Tecnotch"))
    ->send();
``` 

#### Sending an email with one attachment using native php mail() function

```php
$mailer = \Tecnotch\Factory::mailer('simple');
//use reset to clear previous data if you are using already created $mailer object 
//$mailer->reset();
$mailer
	->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
	->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
	->setFrom(array("sender@example.com" => "Tecnotch"))
	->addAttachment(__DIR__ . '/test.pdf', 'Test PDF', 'pdf')
	->setSubject("Email with one attachment sent using simple mail function ")
	->setBody("Please find attachment")
	->send();
```

#### Sending an email with multiple attachments using native php mail() function

```php
$mailer = \Tecnotch\Factory::mailer('simple');

//use reset to clear previous data if you are using already created $mailer object 
//$mailer->reset();

$mailer
	->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
	->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
	->setFrom(array("sender@example.com" => "Tecnotch"))
	->addAttachment(__DIR__ . '/test1.pdf', 'Test PDF 1', 'pdf')
	->addAttachment(__DIR__ . '/test2.pdf', 'Test PDF 2', 'pdf')
	->addAttachment(__DIR__ . '/test3.pdf', 'Test PDF 3', 'pdf')
	->setSubject("Email with multiple attachments sent using simple mail function ")
	->setBody("Please find attachments")
	->send();
;
```
or you can use it as following
```php
$mailer
	->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
	->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
	->setFrom(array("sender@example.com" => "Tecnotch"));
	
$files = array(
	array("name" => "test1.pdf", "title" => "Test PDF 1", "type" => "pdf"),
	array("name" => "test2.pdf", "title" => "Test PDF 2", "type" => "pdf")
);	
foreach ($files as $file) {
	$mailer->addAttachment(__DIR__ . '/' . $file['name'], $file['title'], $file['type']);
}

$mailer->setSubject("Email with multiple attachments sent using simple mail function ")
	->setBody("Please find attachments")
	->send();

```

#### Sending email based on html template and placeholders with attachment(s) using native php mail() function 

```php
$mailer = \Tecnotch\Factory::mailer('simple');
//keep them in order as they are below
$placeholders = array(
	"[user_name]" => "John Doe"
);
$mailer
    ->setPlaceholders($placeholders)
    ->setTemplatePath(__DIR__ . '/html/email/en')
    ->setTemplate("sample.html")
    ->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
    ->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
    ->setFrom(array("sender@example.com" => "Tecnotch"))
    ->setReplyTo(array("sender@example.com" => "Tecnotch-Suport"))
    ->addAttachment(__DIR__ . '/test1.pdf', 'Test PDF 1', 'pdf')
    ->addAttachment(__DIR__ . '/test2.pdf', 'Test PDF 2', 'pdf')
    ->addAttachment(__DIR__ . '/test3.pdf', 'Test PDF 3', 'pdf')
    ->send();
``` 


#### Sending email using smtp (you can configure backend as phpmailer or swiftmailer in Tecnotch/Config.php)

```php
//Default:
//const SMTP_MAILER = 'swiftmailer';
//you can use phpmailer as below
//const SMTP_MAILER = 'phpmailer';

$mailer = \Tecnotch\Factory::mailer('smtp');
$mailer
	->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
	->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
	->setFrom(array("sender@example.com" => "Tecnotch"))
	->setSubject("Simple Email using smtp")
	->setBody("This is simple email without template using smtp ")
	->send();
	
; 
```

#### Sending html template and placeholders based email using smtp 

```php
$placeholders = array(
	"[user_name]" => "John Doe"
);
$mailer = \Tecnotch\Factory::mailer('smtp');
$mailer
	->setPlaceholders($placeholders)
    ->setTemplatePath(__DIR__ . '/html/email/en')
    ->setTemplate("sample.html")
    ->setTo(array("email1@example.com" => "Tofeeq Rehman"))
    ->setFrom(array("sender@example.com" => "Tecnotch"))
    ->send();
```

#### Sending an email with one attachment using smtp

```php
$mailer = \Tecnotch\Factory::mailer('smtp');
//use reset to clear previous data if you are using already created $mailer object 
//$mailer->reset();
$mailer
	->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
	->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
	->setFrom(array("sender@example.com" => "Tecnotch"))
	->setReplyTo(array("sender@example.com" => "Tecnotch-Suport"))
	->addAttachment(__DIR__ . '/test.pdf', 'Test PDF', 'pdf')
	->setSubject("Email with one attachment sent using smtp ")
	->setBody("Please find attachment")
	->send();
; 
```

#### Sending an email with multiple attachments using smtp

```php
$mailer = \Tecnotch\Factory::mailer('smtp');
//use reset to clear previous data if you are using already created $mailer object 
//$mailer->reset();
$mailer
	->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
	->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
	->setFrom(array("sender@example.com" => "Tecnotch"))
	->setReplyTo(array("sender@example.com" => "Tecnotch-Suport"))
	->addAttachment(__DIR__ . '/test1.pdf', 'Test PDF 1', 'pdf')
	->addAttachment(__DIR__ . '/test2.pdf', 'Test PDF 2', 'pdf')
	->addAttachment(__DIR__ . '/test3.pdf', 'Test PDF 3', 'pdf')
	->setSubject("Email with multiple attachments sent using smtp")
	->setBody("Please find attachments")
	->send();
;
```

#### Sending email with attachments based on html templates and placeholders using smtp

```php
$placeholders = array(
	"[user_name]" => "John Doe"
);
$mailer = \Tecnotch\Factory::mailer('smtp');
$mailer
    ->setPlaceholders($placeholders)
    ->setTemplatePath(__DIR__ . '/html/email/en')
    ->setTemplate("sample.html")
    ->setTo(array("email1@example.com" => "Tofeeq Rehman", "email2@example.com" => "Tof33q"))
    ->setCc(array("email3@example.com" => "Tofeeq Testing", "email4@example.com" => "Dev Tofeeq"))
    ->setFrom(array("sender@example.com" => "Tecnotch"))
    ->setReplyTo(array("sender@example.com" => "Tecnotch-Suport"))
    ->addAttachment(__DIR__ . '/test1.pdf', 'Test PDF 1', 'pdf')
    ->addAttachment(__DIR__ . '/test2.pdf', 'Test PDF 2', 'pdf')
    ->addAttachment(__DIR__ . '/test3.pdf', 'Test PDF 3', 'pdf')
    ->send();
;    
```


We use browserstack for testing 
![Alt text](browserstack-logo.jpg?raw=true "BrowserStack")
