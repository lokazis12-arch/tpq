import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';
import { cookies } from 'next/headers';

const publicRoutes = ['/login', '/api/setup', '/api/seed', '/api/auth'];

export async function proxy(request: NextRequest) {
  const path = request.nextUrl.pathname;

  // Allow public routes
  if (publicRoutes.some((route) => path.startsWith(route))) {
    return NextResponse.next();
  }

  // Allow static files
  if (
    path.startsWith('/_next') ||
    path.startsWith('/favicon') ||
    path.includes('.')
  ) {
    return NextResponse.next();
  }

  // Check session cookie
  const sessionCookie = request.cookies.get('session');

  if (!sessionCookie?.value) {
    return NextResponse.redirect(new URL('/login', request.url));
  }

  try {
    const decoded = Buffer.from(sessionCookie.value, 'base64').toString('utf-8');
    const session = JSON.parse(decoded);

    if (!session.id || !session.role) {
      return NextResponse.redirect(new URL('/login', request.url));
    }

    // Role-based route protection
    const guruRoutes = ['/santri', '/absensi', '/bayar', '/progres'];
    const waliRoutes = ['/wali'];

    // If wali_santri tries to access guru-only pages, redirect to /wali
    if (session.role === 'wali_santri' && guruRoutes.some((r) => path.startsWith(r))) {
      return NextResponse.redirect(new URL('/wali', request.url));
    }

    // If wali_santri goes to root /, redirect to /wali
    if (session.role === 'wali_santri' && path === '/') {
      return NextResponse.redirect(new URL('/wali', request.url));
    }

    // If guru tries to access wali-only pages, redirect to /
    if (session.role === 'guru' && waliRoutes.some((r) => path.startsWith(r))) {
      return NextResponse.redirect(new URL('/', request.url));
    }

    return NextResponse.next();
  } catch {
    return NextResponse.redirect(new URL('/login', request.url));
  }
}

export const config = {
  matcher: ['/((?!_next/static|_next/image|favicon.ico|sitemap.xml|robots.txt).*)'],
};
