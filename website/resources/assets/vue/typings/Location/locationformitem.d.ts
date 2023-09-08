declare interface LocationFormItem {
  id?: number;
  title?: string;
  description?: string;
  country_id?: number|null;
  country?: string|null;
  city?: string|null;
  city_id?: number|null;
  is_disabled?: number;
  uploaded_file: File|null;
  media: File|null;
}
