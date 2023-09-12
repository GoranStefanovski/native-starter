declare interface EventFormItem {
  id?: number;
  title?: string;
  owner?: string;
  description?: string;
  is_disabled?: number;
  uploaded_file: File|null;
  media: File|null;
  location_id?: number|null; 
  is_active?: number;
  music_type_id?: number|null;
}
