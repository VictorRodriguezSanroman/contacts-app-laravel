<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_contacts()
    {
        Session::start();
        $token = csrf_token();


        $user = User::factory()->create();

        $contact = Contact::factory()->create([
            'phone_number' => '666555444',
            'user_id' => $user->id,
        ]);


        $response = $this
            ->actingAs($user)
            ->post(route('contacts.store'), $contact->getAttributes(), [
                'X-CSRF-TOKEN' => $token,
            ]);


        $response->assertStatus(302);

        $this->assertDatabaseCount('contacts', 1);

        $this->assertDatabaseHas('contacts', [
            'user_id' => $user->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'age' => $contact->age,
            'phone_number' => $contact->phone_number,
        ]);
    }

    public function test_store_contact_validation()
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->makeOne([
            'phone_number' => "Wrong phone number",
            'email' => "Wrong email",
            'name' => 123,
            'user_id' => 'we'
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('contacts.store'), $contact->getAttributes());

        $this->assertDatabaseCount('contacts', 0);
    }

    /**
     * @depends test_user_can_store_contacts
     */
    public function test_only_owner_can_update_or_delete_contact()
    {
        Session::start();
        $token = csrf_token();
        [$owner, $notOwner] = User::factory(2)->create();

        $contact = Contact::factory()->createOne([
            'phone_number' => '623456789',
            'user_id' => $owner->id,
        ]);


        $response = $this
            ->actingAs($notOwner)
            ->put(route('contacts.update', $contact->id), $contact->getAttributes(), [
                'X-CSRF-TOKEN' => $token,
            ]);

        $location = $response->headers->get('Location');

        $response->assertStatus(302);

        $response = $this
            ->actingAs($notOwner)
            ->delete(route('contacts.destroy', $contact->id), $contact->getAttributes(), [
                'X-CSRF-TOKEN' => $token,
            ]);

        $location = $response->headers->get('Location');

        $response->assertStatus(302);
    }
}
