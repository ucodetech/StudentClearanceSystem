<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone_no = '';
    public string $level = '';
    public string $department = '';
    public string $form_no = '';
    public string $jamb_no = '';
    public string $role = '';
    public string $password = '';
    public string $password_confirmation = '';

    public string $selectedLevel;
    public bool $showFormNo = false;
    public bool $showJambNo = false;
    public $message = '';

    public function updatedLevel(){
        $this->selectedLevel = $this->level;

        if ($this->selectedLevel == "ND1") {
            $this->showJambNo = !$this->showJambNo;
            $this->showFormNo = false;
        }else if($this->selectedLevel =="HND1"){
            $this->showFormNo = !$this->showFormNo;
            $this->showJambNo = false;

        }
    }

    public function updatedEmail(){
        $this->validate([
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:'.User::class]
        ]);
    }

    public function updatedPhoneNo(){
        $this->validate([
            'phone_no' => ['max:11', 'unique:'.User::class]
        ]);
    }
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_no' => ['required', 'string', 'max:11', 'unique:'.User::class],
            'level' => ['required_if:role,student', 'string', 'max:5'],
            'department' => ['required', 'string', 'max:255'],
            'form_no' => ['required_if:level,HND1','integer',  'unique:'.User::class],
            'jamb_no' => ['required_if:level,ND1','string', 'unique:'.User::class],
            'role' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if(empty($this->form_no) && empty($this->jamb_no) && $this->role == "student"){
            $this->message = "Form No and Jamb No can not be empty, one must be entered depending on your level!";
        }

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model.debounce="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

         <!-- Phone no -->
         <div class="mt-4">
            <x-input-label for="phone_no" :value="__('Phone No')" />
            <x-text-input wire:model.debounce="phone_no" id="phone_no" class="block mt-1 w-full py-2" type="phone_no" name="phone_no" required autocomplete="phone_no" />
            <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
        </div>

        <!-- role no -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select wire:model.live='role' name="role" id="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">Select role</option>
                <option value="student">Student</option>
                <option value="admission_office">Admission Office</option>
                <option value="department">Department</option>
                <option value="student_affairs">Student Affairs</option>
                <option value="court">High Court</option>
                <option value="final_admin">Final Admin</option>
            </select>
            <x-select
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
         <!-- Level no -->
            <div class="mt-4">
                <x-input-label for="level" :value="__('Level')" />
                <select wire:model.live='level' name="level" id="level" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">Select level</option>
                    <option value="staff">Staff</option>
                    <option value="ND1">ND1</option>
                    <option value="HND1">HND1</option>
                </select>
                <x-select
                <x-input-error :messages="$errors->get('level')" class="mt-2" />
            </div>

         <!-- Form no -->
         @if ($showFormNo)
            <div class="mt-4">
                <x-input-label for="form_no" :value="__('Form No')" />
                <x-text-input wire:model="form_no" id="form_no" class="block mt-1 w-full py-2" type="form_no" name="form_no" />
                <x-input-error :messages="$errors->get('form_no')" class="mt-2" />
            </div>
         @endif
         @if ($showJambNo)
             <!-- jamb no -->
            <div class="mt-4">
                <x-input-label for="jamb_no" :value="__('Jamb No')" />
                <x-text-input wire:model="jamb_no" id="jamb_no" class="block mt-1 w-full py-2" type="jamb_no" name="jamb_no" />
                <x-input-error :messages="$errors->get('jamb_no')" class="mt-2" />
            </div>
         @endif

         <!-- department no -->
         <div class="mt-4">
            <x-input-label for="department" :value="__('Department')" />
            <x-text-input wire:model="department" id="department" class="block mt-1 w-full py-2" type="department" name="department" />
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>
            
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div>
            <span class="dark:bg-red-600 dark:text-red-300 text-whirte ">{{ $message }}</span>

        </div>
    </form>
</div>
