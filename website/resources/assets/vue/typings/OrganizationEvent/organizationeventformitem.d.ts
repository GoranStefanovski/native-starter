declare interface OrganizationEventFormItem {
  id?: number;
  title?: string;
  name?: string;
  owner?: string;
  description?: string;
  is_disabled?: number;
  uploaded_file: File|null;
  media: File|null;
  location_id?: number|null; 
  is_active?: number|null;
  is_boosted?: number|null;
  music_types?: Array<any>;
  start_date: null;
  end_date: null;
  start_time: null;
  end_time: null;
  country: string;
  city: string;
  address: string;
}