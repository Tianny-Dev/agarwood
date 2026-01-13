import type { RegistrationConfig } from '@/types/registration';

// Shared field definitions
const personalInfoFields = [
  { name: 'first_name', label: 'First Name', type: 'text', placeholder: 'Juan', required: true, autocomplete: 'given-name', step: 2 },
  { name: 'middle_name', label: 'Middle Name', type: 'text', placeholder: 'Dela', required: false, autocomplete: 'additional-name', step: 2 },
  { name: 'last_name', label: 'Last Name', type: 'text', placeholder: 'Cruz', required: true, autocomplete: 'family-name', step: 2 },
  { name: 'birthday', label: 'Birthday', type: 'date', required: true, autocomplete: 'bday', step: 2 },
  { name: 'gender', label: 'Gender', type: 'select', options: [
    { value: 'male', label: 'Male' },
    { value: 'female', label: 'Female' },
    { value: 'other', label: 'Other' },
  ], required: true, step: 2 },
  { name: 'civil_status', label: 'Civil Status', type: 'select', options: [
    { value: 'single', label: 'Single' },
    { value: 'married', label: 'Married' },
    { value: 'widowed', label: 'Widowed' },
    { value: 'separated', label: 'Separated' },
    { value: 'divorced', label: 'Divorced' },
  ], required: true, step: 2 },
];

const contactFields = [
  { name: 'phone_number', label: 'Phone Number', type: 'tel', placeholder: '09123456789', required: true, autocomplete: 'tel', step: 3 },
  { name: 'email', label: 'Email', type: 'email', placeholder: 'juan@example.com', required: true, autocomplete: 'email', step: 3 },
  { name: 'address', label: 'Address', type: 'text', placeholder: '123 Street, City', required: true, autocomplete: 'street-address', step: 3 },
];

const passwordFields = [
  { name: 'password', label: 'Password', type: 'password', placeholder: 'Password', required: true, trailing: true, autocomplete: 'new-password', step: 5 },
  { name: 'password_confirmation', label: 'Confirm Password', type: 'password', placeholder: 'Confirm Password', required: true, trailing: true, autocomplete: 'new-password', step: 5 },
];

const idVerificationFields = [
  { name: 'id_type', label: 'ID Type', type: 'select', options: [
    { value: 'passport', label: 'Passport' },
    { value: 'drivers_license', label: "Driver's License" },
    { value: 'national_id', label: 'National ID' },
    { value: 'sss', label: 'SSS' },
    { value: 'philhealth', label: 'PhilHealth' },
    { value: 'tin', label: 'TIN' },
    { value: 'voters_id', label: "Voter's ID" },
  ], required: true, step: 4 },
  { name: 'id_front', label: 'ID Front', type: 'file', accept: 'image/*,.pdf', help: 'Upload a clear photo of the front of your ID', required: true, step: 4 },
  { name: 'id_back', label: 'ID Back', type: 'file', accept: 'image/*,.pdf', help: 'Upload a clear photo of the back of your ID', required: true, step: 4 },
];

const idVerificationSteps = [
  { title: 'Account Type', description: 'Choose your role', icon: 'i-lucide-user' },
  { title: 'Personal Info', description: 'Name details', icon: 'i-lucide-id-card' },
  { title: 'Contact & Details', description: 'Contact information', icon: 'i-lucide-phone' },
  { title: 'ID Verification', description: 'Upload your ID', icon: 'i-lucide-file-check' },
  { title: 'Security', description: 'Password setup', icon: 'i-lucide-lock' },
];

export const registrationConfig: RegistrationConfig = {
  farmer: {
    steps: [
      { title: 'Account Type', description: 'Choose your role', icon: 'i-lucide-user' },
      { title: 'Personal Info', description: 'Name details', icon: 'i-lucide-id-card' },
      { title: 'Contact & Details', description: 'Contact information', icon: 'i-lucide-phone' },
      { title: 'Farming Background', description: 'Your experience', icon: 'i-lucide-sprout' },
      { title: 'Security', description: 'Password setup', icon: 'i-lucide-lock' },
    ],
    fields: [
      ...personalInfoFields,
      ...contactFields,
      { name: 'farming_background', label: 'Farming Background', type: 'textarea', placeholder: 'Describe your experience', required: false, step: 4 },
      { name: 'years_of_farming', label: 'Years of Farming', type: 'number', placeholder: '5', required: false, step: 4 },
      { name: 'familiarity_tree_cultivation', label: 'Familiarity with Tree Cultivation', type: 'checkbox', required: false, step: 4 },
      ...passwordFields,
    ],
  },

  investor: {
    steps: idVerificationSteps,
    fields: [
      ...personalInfoFields,
      ...contactFields,
      ...idVerificationFields,
      ...passwordFields,
    ],
  },
  
  partner: {
    steps: idVerificationSteps,
    fields: [
      ...personalInfoFields,
      ...contactFields,
      ...idVerificationFields,
      ...passwordFields,
    ],
  },
};