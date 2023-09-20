declare interface LocationFormItem {
  id?: number;
  title?: string;
  description?: string;
  owner?: string;
  country_id?: number|null;
  country?: string|null;
  city?: string|null;
  is_active?: number|null;
  location_types?: Array<any>;
  uploaded_file: File|null;
  media: File|null;
  address: string;
  website: string;
  website_second: string;
  contact_person: string;
  contact_person_second: string;
  contact_person_phone: string;
  contact_person_phone_second: string;
  contact_person_email: string;
  contact_person_email_second: string;
  start_active_date: null;
  end_active_date: null;
}
