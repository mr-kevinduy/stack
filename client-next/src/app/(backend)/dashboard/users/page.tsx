import Table from '@/components/Table';
import { columns } from './table';

const users = [
  {
    'id': 1,
    'fullname' : 'Example',
    'email' : 'example@domain.com',
    'created_at' : '05/05/2024',
    'updated_at' : '05/05/2024',
  },
  {
    'id': 2,
    'fullname' : 'Example 2',
    'email' : 'example2@domain.com',
    'created_at' : '05/05/2024',
    'updated_at' : '06/05/2024',
  },
  {
    'id': 3,
    'fullname' : 'Example 3',
    'email' : 'example3@domain.com',
    'created_at' : '05/05/2024',
    'updated_at' : '06/06/2024',
  }
];

export default function UsersPage() {
  return (
    <div className="users-page">
      <div className="container mx-auto py-8">
        <h2>Users Page</h2>

        <Table data={users} columns={columns}/>
      </div>
    </div>
  );
}
