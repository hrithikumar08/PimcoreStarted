<?php

namespace App\Controller;

use DateTime;
use Exception;
use \Pimcore\Model\DataObject;
// use Pimcore\Log\ApplicationLogger;
use Pimcore\Model\User;
use Pimcore\Bundle\ApplicationLoggerBundle\ApplicationLogger;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Language;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\Document;
use Pimcore\Localization\IntlFormatter;
use Pimcore\SystemSettingsConfig;
use Pimcore\Tool;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\TextPart;
use Pimcore\Bundle\AdminBundle\System\AdminConfig;
use Pimcore\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\DataObject\ParentNews;
use App\Model\DataObject\ChildNews;

class TranslationController extends FrontendController
{
    #[Route('/complaintus')]
    public function languageTest(Request $request, SystemSettingsConfig $config, AdminConfig $config1): Response
    {

        $parentNews = new ParentNews();
        $childNews = new ChildNews();

        echo "Parent News Title: " . $parentNews->getTitle() . "<br>";
        echo "Child News Title: " . $childNews->getTitle() . "<br>";

        // // Get the current session.
        // $session = $request->getSession();

        // // Set a session variable for the `/complaintus` route.
        // $session->set('complaintus', true);

        // // Get the current session.
        // $session = $request->getSession();

        // // Check if the session variable for the `/complaintus` route is set.
        // if ($session->has('complaintus')) {
        //     // Display a special message for users on the `/complaintus` route.
        //     echo 'This is a special message for users on the `/complaintus` route.';
        //     // $session->set('hello', 22);
        // } else {
        //     // Display the default message.
        //     echo 'This is the default message.';
        // }

      
        // \Pimcore\Cache::disable();

        // $mail = new Mail();
        // $mail->setFrom('john.doe@example.com');
        // $mail->addTo('jane.doe@example.com');
        // $mail->setSubject('Test email');
        // $mail->setText('This is the body of the email.');

        // $mail->send();

        // return new Response('Email sent!');
        // $logger = \Pimcore::getLogger();
        // $logger->info('Custom log message');

        // $recipients = ['hrithik.k@codilar.com'];
        // $subject = 'Test email';

        // $mail = Tool::getMail($recipients, $subject);

        // $mail->setBody('This is the body of the emaildsfs');

        // $mail->send();

        // // Create a new message
        // $message = new Message();

        // // Set the sender and recipient
        // $message->setFrom('hrithik.k@codilar.com');
        // $message->addTo('360hrithik.it@gmail.com');

        // // Set the subject of the email
        // $message->setSubject('Test email');

        // // Create a new text part
        // $textPart = new TextPart();

        // // Set the body of the email
        // $textPart->setBody('This is the body of the email.');

        // // Add the text part to the message
        // $message->addPart($textPart);

        // // Send the email
        // $message->send();

        //create a new user for Sydney
        // $user = User::create([
        //     "parentId" => (int) $userGroup->getId(),
        //     "username" => "hrithik",
        //     "password" => "password1234",
        //     "hasCredentials" => true,
        //     "active" => true
        // ]);

        // Create a new user object
        $user = new User();

        // Set user details
        // $user->setUsername('hrithikumar14');
        // $user->setPassword('pass1234'); // You should hash the password for security
        // $user->setEmail('360hrithik.it@gmail.com');
        // $user->setFirstname('jack');
        // $user->setLastname('sparrow');


        // Add roles (optional)
        // $roles = ['ROLE_NAME_1', 'ROLE_NAME_2'];
        // $user->setRoles($roles);

        // Save the user
        // $user->save();

        // Start or resume a session
        // session_start();

        // Set session variables
        // $_SESSION['username'] = 'admin';
        // $_SESSION['user_id'] = 2;
        // $_SESSION['testing'] = 'test_value';

        // Retrieve session data
        // $username = $_SESSION['username'];

        // End the session (usually done during logout)
        // session_destroy();

        $locale = $request->getLocale();
        $language = $this->document->getProperty("language");
        $doc = Document::getById(12);
        $language = $doc->getProperty("language");

        $langdata = Language::getById(30);

        $time = new DateTime();
        $service = \Pimcore::getContainer()->get(IntlFormatter::class);
        $service->setLocale($locale);
        $formattedDate = $service->formatDateTime($time, IntlFormatter::DATETIME_MEDIUM);
        $formattedNumber = $service->formatNumber("45632325.32");
        $formattedCurrency = $service->formatCurrency("45632325.32", "EUR");


        // $object = Language::getById(30); // Get the object
        // dd($versions);

        // $versions = $langdata->getVersions();
        // $langdata->setVersions('301');
        // $langdata->save();

        // $previousVersion = $versions[count($versions) - 2]; // Get the previous version of the object

        // $previousData = $previousVersion->getData(); // Get the data of the previous version of the object
        // // dd($previousData);

        // $langdata->setData($previousData); // Set the data of the object to the data of the previous version

        // $langdata->save(); // Save the object




    $object = DataObject::getById(30);
        // dd($object);

        // $note = new Model\Element\Note();
        // $note->setElement($object);
        // $note->setDate(time());
        // $note->setType("erp_import");
        // $note->setTitle("changed availabilities to xyz");
        // $note->setUser(0);

        // // you can add as much additional data to notes & events as you want
        // $note->addData("myText", "text", "Some Text");
        // $note->addData("myObject", "object", Model\DataObject::getById(7));
        // $note->addData("myDocument", "document", Model\Document::getById(18));
        // $note->addData("myAsset", "asset", Model\Asset::getById(20));

        // $note->save();


        // $tag =  new \Pimcore\Model\Element\Tag();
        // try {
        //     $tag->setName('newtag')->save();
        //     \Pimcore\Model\Element\Tag::addTagToElement('asset', 30, $tag);
        // } catch (Exception $e) {
        //     // echo "";
        // }

        // $tags = \Pimcore\Model\Element\Tag::getTagsForElement('asset', 9);
        // dump($tags);


        // $logger = ApplicationLogger::getInstance();
        // $logger->info('This is an information message.');
        // $logger->warning('This is a warning message.');
        // $logger->error('This is an error message.');


        // use type-hinting to inject the config service
        $config = $config->getSystemSettingsConfig();
        // dd($config);
        // $bar = $config['general']['valid_languages'];
        // print_r($bar);
        // use type-hinting to inject the config service
        $config1 = $config1->getAdminSystemSettingsConfig();
        // dd($config1);
        // $bar = $config['branding']['color_login_screen'];


        return $this->render('lang/default.html.twig', [
            'language' => $language,
            'langdata' => $langdata,
            'formattedDate' => $formattedDate,
            'formattedNumber' => $formattedNumber,
            'formattedCurrency' => $formattedCurrency,
        ]);



    }
}