<?php


namespace App\controllers\admin;

use App\contracts\controllers\ShortCRUDControllerInterface;
use App\model\admin\branch\Branch;
use App\model\admin\contact\Contact;
use App\model\admin\contact\MakeContact;
use App\model\admin\contact\UpdateContact;
use App\model\admin\landscape\Landscape;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;

class ContactController implements ShortCRUDControllerInterface
{
    /**
     * The contact.
     *
     * @var Contact
     */
    private $contact;

    /**
     * The branch
     *
     * @var Branch
     */
    private $branch;

    /**
     * The landscape
     *
     * @var Landscape
     */
    private $landscape;

    /**
     * Construct the contact.
     */
    public function __construct()
    {
        $this->contact = new Contact();
        $this->branch = new Branch();
        $this->landscape = new Landscape();
    }

    /**
     * Overview of all the items.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_contact_maintenance_title');
        $contact = $this->contact->get();
        $contacts = $this->contact->getAll();
        $branches = $this->branch->getAll();
        $landscapes = $this->landscape->getAll();

        return new View('admin/contact/index', compact('title', 'contact', 'contacts', 'branches', 'landscapes'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeContact = new MakeContact();
        if (CSRF::validate() && $makeContact->execute()) {
            return new RedirectResponse('/admin/contact');
        }

        return $this->index();
    }

    /**
     * Update a specific item.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        $updateContact = new UpdateContact();
        if (CSRF::validate() && $updateContact->execute()) {
            return new RedirectResponse('/admin/contact');
        }

        return $this->index();
    }

    /**
     * Soft delete a specific item.
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->contact->softDelete();

        return new RedirectResponse('/admin/contact');
    }
}
