declare interface LocationFormItem {
  id?: number;
  title?: string;
  description?: string;
  owner?: string;
  country_id?: number|null;
  country?: string|null;
  city?: string|null;
  is_active?: number|null;
  location_type_id?: number|null;
  location_type?: string|null;
  uploaded_file: File|null;
  media: File|null;
}
