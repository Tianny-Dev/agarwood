export type UserType = 'farmer' | 'investor';

export interface Field {
  name: string;
  label: string;
  type: string;
  placeholder?: string;
  required?: boolean;
  autocomplete?: string;
  trailing?: boolean;
  step: number;
  options?: { value: string; label: string }[];
  accept?: string;
  help?: string;
}

export interface StepItem {
  title: string;
  description?: string;
  icon?: string;
}

export interface UserTypeConfig {
  steps: StepItem[];
  fields: Field[];
}

export interface RegistrationConfig {
  farmer: UserTypeConfig;
  investor: UserTypeConfig;
}