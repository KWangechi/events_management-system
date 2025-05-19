export type User = {
  id: string;
  name: string;
  email: string;
  role?: "admin" | "user" | "super_admin";
  organization_id?: number;
  createdAt?: Date;
  updatedAt?: Date;
};

export type Organization = {
  id: string;
  name: string;
  slug: string;
  createdAt?: Date;
  updatedAt?: Date;
};



export type Event = {
  id: number;
  title: string;
  description?: string;
  venue: string;
  date: Date;
  price: number;
  maxAttendees: number;
  organization_id?: number;

  created_at?: Date;
  updated_at?: Date;
};

export type EventApiResponse = {
  success: boolean;
  message: string;
  data: Event[];
};

export type Attendee = {
  id: string;
  name: string;
  phone: string;
  createdAt?: Date;
  updatedAt?: Date;
};
