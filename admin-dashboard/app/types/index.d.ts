import type { AvatarProps } from '@nuxt/ui'

export type UserStatus = 'subscribed' | 'unsubscribed' | 'bounced'
export type SaleStatus = 'paid' | 'failed' | 'refunded'

export interface User {
  id: number
  name: string
  email: string
  avatar?: AvatarProps
  status: UserStatus
  location: string
}

export interface Organization {
  id: string
  name: string
  slug: string
  created_at?: Date
  updated_at?: Date
}

export interface Event {
  id: number
  title: string
  description?: string
  venue: string
  date: Date
  price: number
  max_attendees: number
  organization_id?: number
  organization?: Organization
  created_at?: Date
  updated_at?: Date
}

export interface Attendee {
  id: string
  name: string
  phone: string
  event?: Event
  created_at?: Date
  updated_at?: Date
}

export interface Mail {
  id: number
  unread?: boolean
  from: User
  subject: string
  body: string
  date: string
}

export interface Member {
  name: string
  username: string
  role: 'member' | 'owner'
  avatar: Avatar
}

export interface Stat {
  title: string
  icon: string
  value: number | string
  variation: number
  formatter?: (value: number) => string
}

export interface Sale {
  id: string
  date: string
  status: SaleStatus
  email: string
  amount: number
}

export interface Notification {
  id: number
  unread?: boolean
  sender: User
  body: string
  date: string
}

export type Period = 'daily' | 'weekly' | 'monthly'

export interface Range {
  start: Date
  end: Date
}
