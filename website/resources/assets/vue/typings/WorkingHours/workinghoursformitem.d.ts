declare interface WorkingHoursFormItem {
    id?: number;
    location_id?: number|null;
    monday_start: String,
    monday_end: String,
    monday_working: number | null;
    tuesday_start: String,
    tuesday_end: String,
    tuesday_working: number | null;
    wednesday_start: String,
    wednesday_end: String,
    wednesday_working: number | null;
    thursday_start: String,
    thursday_end: String,
    thursday_working: number | null;
    friday_start: String,
    friday_end: String,
    friday_working: number | null;
    saturday_start: String,
    saturday_end: String,
    saturday_working: number | null;
    sunday_start: String,
    sunday_end: String,
    sunday_working: number | null;
    always_open: number | null;
}