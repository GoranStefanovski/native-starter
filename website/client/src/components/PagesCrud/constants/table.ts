import { ColumnObject } from "@/components/Datatables/typings";

export const columns: ColumnObject[] = [
  { id: 0, width: '50%', label: 'pagebuilder.title', name: 'title', sortable: true },
  { id: 1, width: '30%', label: 'pagebuilder.slug', name: 'slug', sortable: true },
  { id: 2, width: '20%', label: 'pagebuilder.actions', name: 'actions', sortable: false },
];
