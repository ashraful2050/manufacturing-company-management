import { Head, Link } from '@inertiajs/react';

const APP_NAME = 'Fan Company Management Software';

const features = [
    { badge: '01', title: 'Fast & Efficient',   desc: 'Built for performance and reliability at any scale.'        },
    { badge: '02', title: 'Secure & Safe',       desc: 'Enterprise-grade security to keep your data protected.'    },
    { badge: '03', title: 'Smart Analytics',     desc: 'Real-time insights and reports to drive better decisions.' },
    { badge: '04', title: 'Team Collaboration',  desc: 'Seamless workflows and tools for your entire team.'        },
];

const stats = [
    ['99.9%', 'Uptime SLA'],
    ['10k+',  'Active Users'],
    ['500+',  'Features'],
    ['24/7',  'Support'],
];

export default function Welcome({ auth, canLogin, canRegister }) {
    return (
        <>
            <Head title={APP_NAME} />

            <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-950 to-indigo-950 text-white">

                {/* ========== Navbar ========== */}
                <nav className="fixed top-0 inset-x-0 z-50 backdrop-blur-md bg-white/5 border-b border-white/10">
                    <div className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

                        <div className="flex items-center gap-3">
                            <div className="w-9 h-9 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center font-bold text-lg shadow-lg">
                                {APP_NAME.charAt(0)}
                            </div>
                            <span className="font-semibold text-lg tracking-tight hidden sm:block">{APP_NAME}</span>
                        </div>

                        <div className="flex items-center gap-2">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 transition text-sm font-medium"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    {canLogin && (
                                        <Link
                                            href={route('login')}
                                            className="px-4 py-2 rounded-lg border border-white/20 hover:border-white/40 hover:bg-white/10 transition text-sm font-medium"
                                        >
                                            Log in
                                        </Link>
                                    )}
                                    {canRegister && (
                                        <Link
                                            href={route('register')}
                                            className="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 transition text-sm font-medium"
                                        >
                                            Get Started
                                        </Link>
                                    )}
                                </>
                            )}
                        </div>
                    </div>
                </nav>

                {/* ========== Hero ========== */}
                <section className="pt-44 pb-20 px-6 text-center">

                    <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-purple-500/30 bg-purple-500/10 text-purple-300 text-xs font-medium mb-8 backdrop-blur-sm">
                        <span className="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse inline-block" />
                        Fully Integrated Management Platform
                    </div>

                    <h1 className="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                        <span className="bg-gradient-to-r from-white via-purple-200 to-indigo-300 bg-clip-text text-transparent">
                            {APP_NAME}
                        </span>
                    </h1>

                    <p className="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                        A powerful, all-in-one platform to manage, track and grow your
                        operations with ease and confidence.
                    </p>

                    <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="px-8 py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 transition text-base font-semibold shadow-lg shadow-purple-900/40"
                            >
                                Go to Dashboard &rarr;
                            </Link>
                        ) : (
                            <>
                                {canRegister && (
                                    <Link
                                        href={route('register')}
                                        className="px-8 py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 transition text-base font-semibold shadow-lg shadow-purple-900/40"
                                    >
                                        Get Started Free &rarr;
                                    </Link>
                                )}
                                {canLogin && (
                                    <Link
                                        href={route('login')}
                                        className="px-8 py-3.5 rounded-xl border border-white/20 hover:border-white/40 hover:bg-white/5 transition text-base font-medium"
                                    >
                                        Sign In
                                    </Link>
                                )}
                            </>
                        )}
                    </div>
                </section>

                {/* ========== Stats strip ========== */}
                <div className="max-w-4xl mx-auto px-6 pb-20">
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        {stats.map(([val, lbl]) => (
                            <div
                                key={lbl}
                                className="rounded-2xl bg-white/5 border border-white/10 p-6 text-center backdrop-blur-sm hover:bg-white/10 transition"
                            >
                                <div className="text-3xl font-extrabold text-white mb-1">{val}</div>
                                <div className="text-xs text-slate-400 uppercase tracking-widest">{lbl}</div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* ========== Features ========== */}
                <section className="max-w-6xl mx-auto px-6 pb-24">
                    <div className="text-center mb-14">
                        <h2 className="text-3xl sm:text-4xl font-bold text-white mb-3">
                            Everything you need
                        </h2>
                        <p className="text-slate-400 max-w-xl mx-auto">
                            Designed to simplify complex workflows and give your team
                            the tools they need to succeed.
                        </p>
                    </div>

                    <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        {features.map((f) => (
                            <div
                                key={f.title}
                                className="group rounded-2xl bg-white/5 border border-white/10 p-6 hover:bg-white/10 hover:border-purple-500/40 transition-all duration-300 backdrop-blur-sm"
                            >
                                <div className="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center font-bold text-sm mb-4 group-hover:bg-purple-500/30 transition">
                                    {f.badge}
                                </div>
                                <h3 className="font-semibold text-white mb-2">{f.title}</h3>
                                <p className="text-sm text-slate-400 leading-relaxed">{f.desc}</p>
                            </div>
                        ))}
                    </div>
                </section>

                {/* ========== CTA Banner ========== */}
                {!auth.user && canRegister && (
                    <section className="max-w-4xl mx-auto px-6 pb-28">
                        <div className="rounded-3xl bg-gradient-to-r from-purple-800/50 to-indigo-800/50 border border-purple-500/30 p-12 text-center backdrop-blur-sm">
                            <h2 className="text-3xl font-bold text-white mb-3">Ready to get started?</h2>
                            <p className="text-slate-400 mb-8 text-lg">
                                Join thousands of teams managing smarter every day.
                            </p>
                            <Link
                                href={route('register')}
                                className="inline-block px-8 py-3.5 rounded-xl bg-white text-slate-900 hover:bg-slate-100 transition font-semibold shadow-xl"
                            >
                                Create a Free Account
                            </Link>
                        </div>
                    </section>
                )}

                {/* ========== Footer ========== */}
                <footer className="border-t border-white/10 py-8">
                    <div className="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                        <div className="flex items-center gap-2">
                            <div className="w-6 h-6 rounded bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                {APP_NAME.charAt(0)}
                            </div>
                            <span>{APP_NAME}</span>
                        </div>
                        <p>&copy; {new Date().getFullYear()} All rights reserved.</p>
                    </div>
                </footer>

            </div>
        </>
    );
}