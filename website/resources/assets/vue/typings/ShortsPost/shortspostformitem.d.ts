declare interface PostFormItem {
  id?: number;
  title?: string;
  description?: string;
  event_id?: number|null;
  location_id?: number|null;
  artist_id?: number|null;
  is_active?: number|null;
  is_boosted?: number|null;
  music_types?: Array<any>;
  location_types?: Array<any>;
  start_active_date?: null;
  end_active_date?: null;
  uploaded_file: File|null;
  media: File|null;
}
