export interface Auth {
    user: User;
    roles: string[]      
    permissions: string[]
}

export interface Agent {
    id: number;
    user: User;
    agent_code: string;
    is_verified: boolean;
    verified_at?: string;
    qr_code_path?: string;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    agents: Agent[]
};

export interface User {
    id: number;
    first_name: string;
    middle_name?: string;
    last_name: string;
    name: string;
    username: string;
    email: string;
    phone_number: string;
    avatar?: string | null;
    cover?: string | null;
    birthday?: string | null;
    gender?: 'male' | 'female' | 'other' | null;
    address?: string | null;
    civil_status?: string | null;
    email_verified_at: string | null
}
