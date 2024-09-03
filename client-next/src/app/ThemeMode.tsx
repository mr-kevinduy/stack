'use client';

import { useState, useEffect } from 'react';
import Button from '@/components/Button';

const ThemeMode = () => {
  const [theme, setTheme] = useState('light');

  useEffect(() => {
    if (theme === 'dark') {
      document.querySelector('html')?.classList.add('dark');
    } else {
      document.querySelector('html')?.classList.remove('dark');
    }
  }, [theme]);

  const changeTheme = (event) => {
    setTheme(theme === 'light' ? 'dark' : 'light');
  };

  return (
    <Button
      className="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
      onClick={changeTheme}
    >Theme Mode</Button>
  );
}

export default ThemeMode;
