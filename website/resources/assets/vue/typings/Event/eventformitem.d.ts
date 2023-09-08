declare interface EventFormItem {
  id?: number;
  title?: string;
  description?: string;
  is_disabled?: number;
  uploaded_file: File|null;
  media: File|null;
}
