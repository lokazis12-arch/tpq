import React from 'react';
import { logoutAction } from '@/lib/actions';

const TopAppBar = ({ userName = 'Pengguna' }: { userName?: string }) => {
  return (
    <header className="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-4 h-16 bg-white dark:bg-slate-900 shadow-sm shadow-emerald-900/5 border-b border-gray-100 dark:border-gray-800">
      <div className="flex items-center gap-3">
        <img src="/logo.png" alt="Logo" className="w-9 h-9 object-contain" />
        <h1 className="font-semibold text-xl text-primary dark:text-emerald-50">Darul Ikhlas</h1>
      </div>
      <div className="flex items-center gap-4">
        <span className="text-sm font-medium text-secondary hidden md:block">{userName}</span>
        <form action={logoutAction}>
          <button type="submit" className="w-10 h-10 rounded-full hover:bg-error-container transition-colors flex items-center justify-center text-error active:scale-95" title="Logout">
            <span className="material-symbols-outlined">logout</span>
          </button>
        </form>
      </div>
    </header>
  );
};

export default TopAppBar;

