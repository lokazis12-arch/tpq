'use client';

import React from 'react';
import Link from 'next/link';
import { usePathname } from 'next/navigation';

const BottomNavBar = ({ role = 'guru' }: { role?: string }) => {
  const pathname = usePathname();

  const guruNavItems = [
    { label: 'Dashboard', icon: 'dashboard', href: '/' },
    { label: 'Santri', icon: 'group', href: '/santri' },
    { label: 'Absensi', icon: 'fact_check', href: '/absensi' },
    { label: 'Progres', icon: 'trending_up', href: '/progres' },
    { label: 'Bayar', icon: 'payments', href: '/bayar' },
  ];

  const waliNavItems = [
    { label: 'Beranda', icon: 'home', href: '/wali' },
    { label: 'Laporan', icon: 'description', href: '/wali/laporan' },
    { label: 'Presensi', icon: 'calendar_month', href: '/wali/presensi' },
    { label: 'Profil', icon: 'person', href: '/wali/profil' },
  ];

  const navItems = role === 'guru' ? guruNavItems : waliNavItems;

  return (
    <nav className="fixed bottom-0 left-0 w-full bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-800 pb-safe z-50 shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
      <div className="flex justify-around items-center h-20 max-w-md mx-auto">
        {navItems.map((item) => {
          const isActive = pathname === item.href || (item.href !== '/' && pathname.startsWith(item.href) && item.href !== '/wali');
          return (
            <Link
              key={item.label}
              href={item.href}
              className="flex flex-col items-center justify-center w-full h-full gap-1 active:scale-95 transition-transform"
            >
              <div
                className={`flex items-center justify-center w-16 h-8 rounded-full transition-colors ${
                  isActive ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant'
                }`}
              >
                <span className={`material-symbols-outlined ${isActive ? 'filled' : ''}`}>
                  {item.icon}
                </span>
              </div>
              <span
                className={`text-xs font-medium ${
                  isActive ? 'text-on-surface' : 'text-on-surface-variant'
                }`}
              >
                {item.label}
              </span>
            </Link>
          );
        })}
      </div>
    </nav>
  );
};

export default BottomNavBar;
