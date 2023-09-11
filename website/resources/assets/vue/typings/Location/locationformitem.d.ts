declare interface LocationFormItem {
  id?: number;
  title?: string;
  description?: string;
  owner?: string;
  country_id?: number|null;
  country?: string|null;
  city?: string|null;
  is_active?: number;
  uploaded_file: File|null;
  media: File|null;
}
