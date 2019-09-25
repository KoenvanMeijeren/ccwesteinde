<?php


namespace App\controllers;

use App\contracts\controllers\ContactControllerInterface;
use App\model\admin\contact\Contact as AdminContact;
use App\model\admin\page\Page;
use App\model\contact\Contact;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;

class ContactController implements ContactControllerInterface
{
    /**
     * Show the contact page.
     *
     * @return View
     */
    public function index()
    {
        $contacts = new AdminContact();
        $page = new Page('contact');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('contact_page_title');
        $contacts = $contacts->getAll();

        return new View('contact/index', compact('title', 'contacts', 'page'));
    }

    /**
     * Proceed the call from the method index and send the contact form.
     *
     * @return RedirectResponse|View
     */
    public function contact()
    {
        $contact = new Contact();
        if ($contact->execute()) {
            return new RedirectResponse('/contact-verzonden');
        }

        return $this->index();
    }

    /**
     * Show the contact sent page.
     *
     * @return View
     */
    public function sent()
    {
        $page = new Page('contact-verzonden');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('contact_page_title');

        return new View('contact/sent', compact('title', 'page'));
    }
}
