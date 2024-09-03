import Link from 'next/link';
import AuthCard  from '@/app/(auth)/AuthCard';
import ApplicationLogo from '@/components/ApplicationLogo';

export default function AuthLayout({ children }): Readonly<{
  children: React.ReactNode
}> {
  return (
    <div className="auth-layout">
      <AuthCard
        logo={
          <Link href="/">
            <span className="flex justify-center">
              <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
            </span>
          </Link>
        }>
        {children}
      </AuthCard>
    </div>
  );
}
