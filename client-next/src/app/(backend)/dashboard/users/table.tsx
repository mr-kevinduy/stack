import { CalendarIcon } from '@heroicons/react/24/solid';
import Text from '@/components/Table/Text';

export const columns = [
  {
    'name': 'fullname',
    'data': 'fullname',
    'label': 'Fullname',
    'sortable': true,
  },

  {
    'name': 'email',
    'data': 'email',
    'label': 'Email',
    'sortable': true,
  },

  {
    'name': 'date',
    'data': ['created_at', 'updated_at'],
    'label': 'Created Date',
    'render': (col, record) => {
      console.log(record);
      return (
        <>
          <CalendarIcon className="h-5 w-5 text-gray-400 dark:text-gray-500" />
          <Text>{col.name + ' ABC ' + record.created_at + ' - ' + record.updated_at}</Text>
        </>
      );
    },
  }
];
