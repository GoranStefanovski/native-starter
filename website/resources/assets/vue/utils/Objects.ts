import { createFile } from '@/utils/edgeFileUpload';
import { cloneDeep } from 'lodash';
import {IStaticContentForm} from "@/features/Admin/StaticContentTypes";

const cliche: ClicheFormItem = {
  type: '',
  width: undefined,
  height: undefined
};

const product: ProductFormItem = {
  name: '',
  height: '',
  width: '',
  length: '',
  handle_id: null,
  lamination_id: null,
  paper_id: null,
  bottom: '',
  printed_bottom: '',
  front_back: '',
  spot_uv: '',
  hot_foil: '',
  hot_foil_cliches: [cloneDeep(cliche), cloneDeep(cliche), cloneDeep(cliche)],
  embossing: '',
  embossing_cliches: [cloneDeep(cliche), cloneDeep(cliche), cloneDeep(cliche)],
  outside_colors: [],
  inside_colors: [],
  quantity: '',
  comment: '',
  display_name: '',
  paper: {},
  handle: {},
  lamination: {},
  min_offer: 0,
  max_package_weight: 15
};

const offer: OfferFormItem = {
  name: '',
  days_to_delivery: undefined,
  price: undefined,
  product_id: undefined,
  product: cloneDeep(product)
};

const detail: DetailsFormItem = {
  address: '',
  alt_address: '',
  city: '',
  country_id: '',
  company: '',
  company_vat: '',
  name: '',
  phone: undefined
};

const order: OrderFormItem = {
  status: '',
  offer_id: '',
  shipping_detail_id: null,
  billing_detail_id: null,
  shipping_details: cloneDeep(detail),
  billing_details: cloneDeep(detail),
  offer: cloneDeep(offer)
};

const user: UserFormItem = {
  id: 0,
  username: '',
  email: '',
  first_name: '',
  last_name: '',
  password: '',
  password_confirmation: '',
  roles: [],
  roles_array: [],
  is_disabled: 1,
  country_id: '',
  uploaded_file: createFile('image/jpg'),
  media: createFile('image/jpg'),
  json_data: '',
  company: '',
  phone: '',
  source: 'backend',
  contact_email: '',
  sub_type: 0,
  sub_name: ''
};

const post: PostFormItem = {
  id: 0,
  title: '',
  description: '',
  event_id: null,
  location_id: null,
  artist_id: null,
  is_active: null,
  is_boosted: null,
  music_types: [],
  location_types: [],
  start_active_date: null,
  end_active_date: null,
  uploaded_file: createFile('image/jpg'),
  media: createFile('image/jpg')
}


const shorts_post: ShortsPostFormItem = {
  id: 0,
  title: '',
  link: '',
  event_id: null,
  location_id: null,
  artist_id: null,
  is_active: null,
  is_boosted: null,
  music_types: [],
  location_types: [],
  start_active_date: null,
  end_active_date: null,
}

const location: LocationFormItem = {
  id: 0,
  title: '',
  description: '',
  location_types: [],
  country_id: 0,
  country: 'Bulgaria',
  address: '',
  city: '',
  is_active: null,
  website: '',
  website_second: '',
  contact_person: '',
  contact_person_second: '',
  contact_person_phone: '',
  contact_person_phone_second: '',
  contact_person_email: '',
  contact_person_email_second: '',
  start_active_date: null,
  end_active_date: null,
  uploaded_file: createFile('image/jpg'),
  media: createFile('image/jpg')
}

const event: EventFormItem = {
  id: 0,
  title: '',
  description: '',
  is_disabled: 0,
  name: '',
  location_id: null,
  is_active: null,
  start_date: null,
  end_date: null,
  start_time: null,
  end_time: null,
  location_name: '',
  location_address: '',
  music_types: [],
  uploaded_file: createFile('image/jpg'),
  media: createFile('image/jpg')
}

const organization_events: OrganizationEventFormItem = {
  id: 0,
  title: '',
  description: '',
  name: '',
  is_active: null,
  is_boosted: null,
  start_date: null,
  end_date: null,
  start_time: null,
  end_time: null,
  address: '',
  city: '',
  music_types: [],
  country: 'Bulgaria',
  uploaded_file: createFile('image/jpg'),
  media: createFile('image/jpg')
}

const working_hours: WorkingHoursFormItem = {
  id: 0,
  location_id: null,
  monday_start: '',
  monday_end: '',
  monday_working: null,
  tuesday_start: '',
  tuesday_end: '',
  tuesday_working: null,
  wednesday_start: '',
  wednesday_end: '',
  wednesday_working: null,
  thursday_start: '',
  thursday_end: '',
  thursday_working: null,
  friday_start: '',
  friday_end: '',
  friday_working: null,
  saturday_start: '',
  saturday_end: '',
  saturday_working: null,
  sunday_start: '',
  sunday_end: '',
  sunday_working: null,
  always_open: null,
}


const slide: SlideFormItem = {
  id: 0,
  title: '',
  subtitle: '',
  description: '',
  image: '',
  learn_more_text: '',
  learn_more_link_custom: false,
  learn_more_link: '',
  learn_more_color: '',
  get_started_text: '',
  get_started_link_custom: false,
  get_started_link: '',
  get_started_color: '',
  uploaded_file: createFile('image/jpg')
};

const shipping: Object = {
  base_price: 0,
  price_kg: 0,
  min_price: 0,
  max_palete_weight: 0
};
const lamination: Object = {
  id: 0,
  order: 0,
  name: '',
  display_name: '',
  price: ''
};
const color: Object = {
  id: 0,
  order: 0,
  name: '',
  display_name: '',
  type: '',
  hex_value: ''
};
const combination: Object = {
  id: 0,
  order: 0,
  name: '',
  display_name: '',
  price: ''
};
const format: Object = {
  id: 0,
  order: 0,
  name: '',
  parts: '',
  gluing_coefficient: '',
  format_coefficient: ''
};
const paper: Object = {
  id: 0,
  order: 0,
  name: '',
  display_name: '',
  price: '',
  margin: '',
  type: '',
  weight: ''
};
const parameter: Object = {
  id: 0,
  order: 0,
  name: '',
  display_name: '',
  value: ''
};
const handle: Object = {
  id: 0,
  order: 0,
  name: '',
  display_name: '',
  fold: '',
  price: '',
  tying: '',
  height: '',
  width: ''
};

const appointment: AppointmentFormItem = {
  id: null,
  start: '',
  end: '',
  date: new Date().toISOString().split('T')[0],
  duration: 0,
  user_id: null,
  time : null,
  services: [],
  status: 1
};

const staticContent: IStaticContentForm = {
  title: '',
  description: '',
  page_path: ''
}

export {
  product,
  order,
  offer,
  detail,
  cliche,
  user,
  post,
  shorts_post,
  slide,
  location,
  event,
  organization_events,
  shipping,
  lamination,
  color,
  combination,
  format,
  paper,
  parameter,
  handle,
  appointment,
  staticContent,
  working_hours
};
