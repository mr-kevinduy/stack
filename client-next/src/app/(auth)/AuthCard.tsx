export default function AuthCard({ logo, children }) {
  return (
    <div className="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        {logo}

        <h2 className="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
          Sign in to your account
        </h2>

        <p className="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
            Or{" "}
          <a href="/register" className="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
            create a new account
          </a>
        </p>
      </div>

      <main className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div className="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
          {children}
        </div>
      </main>
    </div>
  );
}
