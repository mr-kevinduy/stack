'use client';

import { useState } from 'react';
import Link from 'next/link';
import Button from '@/components/Button';
import Label from '@/components/Label';
import Input from '@/components/Input';
import InputError from '@/components/InputError';
// import { useAuth } from '@/hooks/auth';

export default function LoginPage() {
  // const { login } = useAuth({
  //   middleware: 'guest',
  //   redirectIfAuthenticated: '/dashboard',
  // });

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [shouldRemember, setShouldRemember] = useState(false);
  const [errors, setErrors] = useState([]);

  const submitForm = async event => {
    event.preventDefault();

    // login({
    //   email,
    //   password,
    //   remember: shouldRemember,
    //   setErrors,
    //   setStatus,
    // });
  };

  return (
    <>
      <form onSubmit={submitForm}>
        {/* Email Address */}
        <div>
          <Label htmlFor="email">Email address</Label>

          <Input
            id="email"
            type="email"
            value={email}
            className="block mt-1 w-full"
            onChange={event => setEmail(event.target.value)}
            required
            autoFocus
          />

          <InputError messages={errors.email} className="mt-2" />
        </div>

        {/* Password */}
        <div className="mt-4">
          <Label htmlFor="password">Password</Label>

          <Input
            id="password"
            type="password"
            value={password}
            className="block mt-1 w-full"
            onChange={event => setPassword(event.target.value)}
            required
            autoComplete="current-password"
          />

          <InputError
            messages={errors.password}
            className="mt-2"
          />
        </div>

        <div className="flex items-center justify-between mt-4">
          {/* Remember Me */}
          <div className="block">
            <label
              htmlFor="remember_me"
              className="inline-flex items-center">
              <input
                id="remember_me"
                type="checkbox"
                name="remember"
                className="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                onChange={event =>
                  setShouldRemember(event.target.checked)
                }
              />

              <span className="ml-2 text-sm text-gray-600">
                Remember me
              </span>
            </label>
          </div>

          <Link
            href="/forgot-password"
            className="underline text-sm text-gray-600 hover:text-gray-900">
            Forgot your password?
          </Link>
        </div>

        <div className="flex items-center justify-end mt-4">
          <Button className="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out">Login</Button>
        </div>
      </form>
    </>
  );
}
