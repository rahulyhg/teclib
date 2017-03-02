# Teclib
A handy and very easy to use library of different packages i.e sending emails both simple and smtp, making payments using paypal or other payment processors ...

## Mail
This package is most easiest way to send html template based emails using either by simple mail function or using smtp (swiftmailer or phpmailer etc)

Mail is php library created for sending emails with an ease using html templates and placeholders:

 * You can create html templates and placeholders to send email
 * Supports attachments
 * You can choose to send email by core php mail function or smtp
 * For smtp it has PHPMailer and SwiftMailer as backend, you can choose any of these by simple config option, default is SwiftMailer

It is very easy to use, just create a mailer object and start sending emails.

### Installation
Git clone or download the repo in the directory where your mail sending script exists

### Configuration for email if sending via smtp
open config_email.php and provide your smtp host name, user name and password if you need to send emails using smtp, ignore it if you are going to use native mail function of php

```php
 {
    "smtp_backend" 	: "phpmailer",
    "smtp_host"  	: "smtp.gmail.com",
    "smtp_port"  	: "465",
    "smtp_username" : "your smtp username",
    "smtp_password" : "your smtp password"
}
```


* There is an example file included as email_examples.php

In your mail sending script just use
```php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch\Factory as Factory;
```
Create mailer object and start sending emails 


### Creating mailer object
Create mailer which uses core php mail() function
```php
$mailer = Factory::mailer('simple');
```

Create SMTP mailer
```php
$mailer = Factory::mailer('smtp');
//You can configure backend as phpmailer or swiftmailer in config_email.php
```

### Examples


#### Sending a simple email using native mail() function of php 

```php
$mailer = Factory::mailer('simple');
 
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
$mailer = Factory::mailer('simple');

$placeholders = array(
	"[user_name]" => "John Doe"
);

//keep the chain in order as they are below
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
$mailer = Factory::mailer('simple');
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
$mailer = Factory::mailer('simple');

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
$mailer = Factory::mailer('simple');
 
$placeholders = array(
	"[user_name]" => "John Doe"
);

//keep the chain in order as they are below
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
$mailer = Factory::mailer('smtp');
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
$mailer = Factory::mailer('smtp');
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
$mailer = Factory::mailer('smtp');

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
$mailer = Factory::mailer('smtp');

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

$mailer = Factory::mailer('smtp');

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


## Payment

Payment library can be used to integrate different payments gateways in your website, for now Stripe and PayPal are supported

There are no of examples included in root directory for performing various tasks related to payments.

### Configuration for payment gateway
Open config_payment.php and provide your payment gateway/processor configuration, for example if you are using paypal you can provide following configuration

```php
 {
    "gateway" : "paypal",
    "currency"  : "USD",
    "mode"  : "test",
    "merchant_email" : "yourbusiness@email",    
    "api_key" : "restapikey",
    "api_secret" : "restapisecret",
    "api_signature" : "signature if used in your payment gateway, leave it as it is if you don't have",
    "weight_unit" : "lbs",
    "instructions" : "to set it live replace mode:test to mode:live"
}
```

### Usage

```php
require_once 'Tecnotch/bootstrap.php';
use \Tecnotch\Payment\Factory as Factory;

//create standard payment i.e user has to pay on PayPal site
$payment = Factory::simplePayment();

$payment
    //business email
    
    //store urls
    ->setReturnUrl("http://www.example.php/return.php")
    ->setCancelUrl("http://www.example.php/cancel.php")
    ->setNotifyUrl("http://www.example.php/silent.php")
    ->setShoppingUrl("http://www.example.php")
    
    //personal detail
    ->setEmail("developer.tofeeq@gmail.com")
    ->setFirstName("Tofeeq")
    ->setLastName("Rehman")
    
    //personal billing address 
    ->setStreet("Street 2")
    ->setCity("Multan")
    ->setState("Punjab")
    ->setZip(60000)
    ->setLocale("EN_US")
    ->setPhone('923017874905')
    
    
    ->setInvoice(123)
 
    ->setParam('cmd', '_cart')
    ->setParam('upload', 1)
    
    ->setParam('custom', 'sometext')
    
    
    ;
$items = array(
  array(
      "id" => 1,
      "name" => "test item",
      "quantity" => 3,
      "price"   => 10,
      "tax" => 1,
      "shipping" => 4,
      "handling" => 3,
      "discount" => 2
  ),
  array(
      "id" => 2,
      "name" => "test item 2",
      "quantity" => 4,
      "price"   => 4,
      "tax" => 2,
      "shipping" => 3,
      "handling" => 2,
      "discount" => 2.5
  )  
);

foreach ($items as $item) {
    $payItem = new \Tecnotch\Payment\Item();
    $payItem->setId($item['id'])
        ->setName($item['name'])
        ->setQuantity($item['quantity'])
        ->setPrice($item['price'])
        ->setTax($item['tax'])
        ->setShipping($item['shipping'])
        ->setHandling($item['handling'])
        ->setDiscount($item['discount']);
        
    $payment->addItem($payItem);    
}
			
$payment->setButton(array('value' => 'Subscribe', 'class' => ""))
echo $payment->execute();


```


![Alt text](browserstack-logo.jpg?raw=true "BrowserStack")
We use browserstack for testing 
