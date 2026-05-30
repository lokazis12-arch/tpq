import TopAppBar from "@/components/TopAppBar";
import BottomNavBar from "@/components/BottomNavBar";
import { getSession } from "@/lib/auth";
import { redirect } from "next/navigation";

export default async function AppLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const session = await getSession();
  if (!session) redirect('/login');

  return (
    <div className="pt-16 pb-24 min-h-screen bg-surface">
      <TopAppBar userName={session.name} />
      <main className="flex-grow container mx-auto px-4 py-6 max-w-7xl">
        {children}
      </main>
      <BottomNavBar role={session.role} />
    </div>
  );
}
