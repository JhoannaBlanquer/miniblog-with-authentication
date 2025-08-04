import React, { useState, useEffect, useRef } from 'react';
import * as Tabs from '@radix-ui/react-tabs';
import * as Dialog from '@radix-ui/react-dialog';
import * as DropdownMenu from '@radix-ui/react-dropdown-menu';

export default function AdminDashboard() {
    const [openModal, setOpenModal] = useState(false);
    const [posts, setPosts] = useState([]);
    const [users, setUsers] = useState([]);
    const [userCount, setUserCount] = useState(0);
    const [postCount, setPostCount] = useState(0);

    useEffect(() => {
        setPosts(window.posts || []);
        setUsers(window.users || []);
        setUserCount(window.userCount || 0);
        setPostCount(window.postCount || 0);
    }, []);

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const handleLogout = () => {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Content-Type': 'application/json',
            },
        }).then(() => {
            window.location.href = '/';
        });
    };

    // Add new post to table
    const handlePostCreated = (post) => {
        setPosts([post, ...posts]);
        setPostCount(postCount + 1);
    };

    // Add new user to table
    const handleUserCreated = (user) => {
        setUsers([user, ...users]);
        setUserCount(userCount + 1);
    };

    return (
        <div className="flex flex-col min-h-screen font-sans bg-blue-100 text-gray-900">
            {/* Header */}
            <header className="bg-[#00306D] shadow-lg">
                <nav className="flex items-center justify-between px-6 py-4 text-white relative max-w-7xl mx-auto w-full">
                    <div className="absolute left-1/2 transform -translate-x-1/2">
                        <img src="/images/logo.png" alt="Logo" className="h-[110px] object-contain" />
                    </div>
                    <a href="/" className="nav-link z-10 relative">Home</a>
                    <DropdownMenu.Root>
                        <DropdownMenu.Trigger asChild>
                            <button className="round-btn overflow-hidden p-0 w-10 h-10 rounded-full border-2 border-white z-10 relative">
                                <img src="/images/admin.jpg" alt="Profile" className="w-full h-full object-cover rounded-full" />
                            </button>
                        </DropdownMenu.Trigger>
                        <DropdownMenu.Portal>
                            <DropdownMenu.Content
                                className="w-48 bg-white border border-[#00306D]/20 rounded-xl shadow-xl z-50 py-3 px-4 space-y-2 text-sm text-[#00306D] mt-2"
                                sideOffset={8}
                                align="end"
                            >
                                <DropdownMenu.Item
                                    onSelect={handleLogout}
                                    className="w-full text-left px-3 py-2 hover:bg-red-100 transition cursor-pointer rounded-md"
                                >
                                    Logout
                                </DropdownMenu.Item>
                            </DropdownMenu.Content>
                        </DropdownMenu.Portal>
                    </DropdownMenu.Root>
                </nav>
            </header>

            {/* Main */}
            <main className="flex-1 p-6">
                <div className="flex justify-center gap-8 mb-6">
                    <SummaryCard title="Posts" count={postCount} />
                    <SummaryCard title="Users" count={userCount} />
                </div>

                <Tabs.Root defaultValue="posts" className="w-full max-w-5xl mx-auto">
                    <Tabs.List className="flex justify-center space-x-6 border-b mb-6">
                        <TabTrigger value="posts">Posts</TabTrigger>
                        <TabTrigger value="users">Users</TabTrigger>
                    </Tabs.List>

                    <Tabs.Content value="posts">
                        <h2 className="text-2xl font-bold text-[#00306D] mb-6">All Posts</h2>
                        <div className="flex justify-end mb-6">
                            <button
                                onClick={() => setOpenModal(true)}
                                className="bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded font-semibold transition"
                            >
                                New Post
                            </button>
                        </div>
                        <NewPostDialog open={openModal} setOpen={setOpenModal} csrf={csrf} onCreated={handlePostCreated} />
                        <DataTable data={posts} type="post" csrf={csrf} />
                    </Tabs.Content>

                    <Tabs.Content value="users">
                        <h2 className="text-2xl font-bold text-[#00306D] mb-4">User Management</h2>
                        <AddUserDialog csrf={csrf} onCreated={handleUserCreated} />
                        <DataTable data={users} type="user" csrf={csrf} />
                    </Tabs.Content>
                </Tabs.Root>
            </main>

            <footer className="bg-[#00306D] text-white text-center py-4 text-sm mt-6">
                &copy; {new Date().getFullYear()} WonderWhere. All rights reserved.
            </footer>
        </div>
    );
}

function SummaryCard({ title, count }) {
    return (
        <div className="bg-[#00306D] text-white p-6 rounded-xl shadow-lg text-center w-40 border-4 border-blue-300">
            <h2 className="text-lg font-semibold">{title}</h2>
            <p className="text-3xl font-bold">{count}</p>
        </div>
    );
}

function TabTrigger({ value, children }) {
    return (
        <Tabs.Trigger
            value={value}
            className="py-2 px-6 text-[#00306D] text-lg font-semibold border-b-2 border-transparent data-[state=active]:border-[#00306D]"
        >
            {children}
        </Tabs.Trigger>
    );
}

function NewPostDialog({ open, setOpen, csrf, onCreated }) {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const titleRef = useRef();
    const bodyRef = useRef();
    const imageRef = useRef();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');
        const formData = new FormData();
        formData.append('title', titleRef.current.value);
        formData.append('body', bodyRef.current.value);
        if (imageRef.current.files[0]) {
            formData.append('image', imageRef.current.files[0]);
        }
        try {
            const res = await fetch('/posts', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                body: formData,
            });
            if (!res.ok) throw new Error('Failed to create post');
            const data = await res.json();
            onCreated(data);
            setOpen(false);
        } catch (err) {
            setError('Failed to create post.');
        }
        setLoading(false);
    };

    return (
        <Dialog.Root open={open} onOpenChange={setOpen}>
            <Dialog.Portal>
                <Dialog.Overlay className="fixed inset-0 bg-black/30" />
                <Dialog.Content className="fixed top-[10%] left-1/2 -translate-x-1/2 w-full max-w-md bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10">
                    <Dialog.Title className="text-2xl font-extrabold text-[#00306D] mb-6 text-center">
                        Create a New Post
                    </Dialog.Title>
                    <form onSubmit={handleSubmit} encType="multipart/form-data" className="space-y-5">
                        {/* Title */}
                        <div>
                            <label htmlFor="title" className="block mb-1 font-medium text-[#00306D]">Post Title</label>
                            <input
                                type="text"
                                name="title"
                                ref={titleRef}
                                className="input w-full"
                                required
                            />
                        </div>

                        {/* Body */}
                        <div>
                            <label htmlFor="body" className="block mb-1 font-medium text-[#00306D]">Post Content</label>
                            <textarea
                                name="body"
                                rows={5}
                                ref={bodyRef}
                                className="input w-full"
                                required
                            ></textarea>
                        </div>

                        {/* Image Upload */}
                        <div>
                            <label className="block mb-1 font-medium text-[#00306D]">Upload Image</label>
                            <input
                                type="file"
                                name="image"
                                ref={imageRef}
                                className="file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="image/*"
                            />
                        </div>

                        {/* Error */}
                        {error && <p className="text-red-500 text-sm">{error}</p>}

                        {/* Submit */}
                        <button
                            type="submit"
                            disabled={loading}
                            className="w-full bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded transition font-semibold"
                        >
                            {loading ? 'Saving...' : 'Create Post'}
                        </button>
                    </form>
                    <Dialog.Close className="absolute top-3 right-4 text-xl font-bold text-gray-500 hover:text-gray-700">×</Dialog.Close>
                </Dialog.Content>
            </Dialog.Portal>
        </Dialog.Root>
    );
}


function AddUserDialog({ csrf, onCreated }) {
    const [open, setOpen] = useState(false);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const nameRef = useRef();
    const emailRef = useRef();
    const passwordRef = useRef();
    const confirmPasswordRef = useRef();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        if (passwordRef.current.value !== confirmPasswordRef.current.value) {
            setError('Passwords do not match.');
            setLoading(false);
            return;
        }

        try {
            const res = await fetch('/users', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: nameRef.current.value,
                    email: emailRef.current.value,
                    password: passwordRef.current.value,
                    password_confirmation: confirmPasswordRef.current.value,
                }),
            });
            if (!res.ok) throw new Error('Failed to create user');
            const data = await res.json();
            onCreated(data);
            setOpen(false);
        } catch (err) {
            setError('Failed to create user.');
        }
        setLoading(false);
    };

    return (
        <Dialog.Root open={open} onOpenChange={setOpen}>
            <div className="flex justify-end mb-4">
                <Dialog.Trigger className="bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded font-semibold transition">
                    Add User
                </Dialog.Trigger>
            </div>

            <Dialog.Portal>
                <Dialog.Overlay className="fixed inset-0 bg-black/30 z-40" />
                <Dialog.Content className="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md bg-white shadow-xl rounded-xl border border-[#00306D]/20 p-10">
                    <Dialog.Title className="text-2xl font-extrabold text-[#00306D] mb-6 text-center">
                        Register a New User
                    </Dialog.Title>

                    <form onSubmit={handleSubmit} className="space-y-5">
                        {/* Username */}
                        <div>
                            <label className="block mb-1 font-medium text-[#00306D]">Username</label>
                            <input
                                type="text"
                                ref={nameRef}
                                name="name"
                                required
                                className="input w-full"
                            />
                        </div>

                        {/* Email */}
                        <div>
                            <label className="block mb-1 font-medium text-[#00306D]">Email</label>
                            <input
                                type="email"
                                ref={emailRef}
                                name="email"
                                required
                                className="input w-full"
                            />
                        </div>

                        {/* Password */}
                        <div>
                            <label className="block mb-1 font-medium text-[#00306D]">Password</label>
                            <input
                                type="password"
                                ref={passwordRef}
                                name="password"
                                required
                                className="input w-full"
                            />
                        </div>

                        {/* Confirm Password */}
                        <div>
                            <label className="block mb-1 font-medium text-[#00306D]">Confirm Password</label>
                            <input
                                type="password"
                                ref={confirmPasswordRef}
                                name="password_confirmation"
                                required
                                className="input w-full"
                            />
                        </div>

                        {/* Error */}
                        {error && <p className="text-red-600 text-sm">{error}</p>}

                        {/* Submit */}
                        <button
                            type="submit"
                            disabled={loading}
                            className="w-full bg-[#00306D] hover:bg-blue-900 text-white px-4 py-2 rounded transition font-semibold"
                        >
                            {loading ? 'Creating...' : 'Register'}
                        </button>
                    </form>

                    <Dialog.Close className="absolute top-2 right-3 text-lg font-bold text-gray-500 hover:text-gray-700 cursor-pointer">
                        ×
                    </Dialog.Close>
                </Dialog.Content>
            </Dialog.Portal>
        </Dialog.Root>
    );
}


function DataTable({ data, type, csrf }) {
    const headers = type === 'post' ? ['ID', 'Title'] : ['ID', 'Name'];

    return (
        <div className="bg-white rounded-xl shadow-lg overflow-hidden border border-[#00306D]/20">
            <div className="grid grid-cols-3 font-semibold bg-gray-100 px-6 py-4 border-b border-gray-300">
                {headers.map(header => <div key={header}>{header}</div>)}
                <div className="text-right">Actions</div>
            </div>
            {data.length > 0 ? data.map((item, index) => (
                <div key={item.id} className={`grid grid-cols-3 items-center px-6 py-4 border-b transition ${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'} hover:bg-gray-100`}>
                    <div>{item.id}</div>
                    <div>{item.name || item.title}</div>
                <div className="flex justify-end space-x-2">
                    {type === 'post' ? (
                        <>
                            {/* View Post */}
                            <a
                                href={`/posts/${item.id}`}
                                className="text-sm bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition"
                            >
                                View
                            </a>

                            {/* Edit Post */}
                            <a
                                href={`/posts/${item.id}/edit`}
                                className="text-sm bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition"
                            >
                                Edit
                            </a>

                            {/* Delete Post */}
                            <form
                                method="POST"
                                action={`/posts/${item.id}`}
                                onSubmit={(e) => {
                                    if (!confirm("Are you sure you want to delete this post?")) e.preventDefault();
                                }}
                            >
                                <input type="hidden" name="_method" value="DELETE" />
                                <input type="hidden" name="_token" value={csrf} />
                                <button
                                    type="submit"
                                    className="text-sm bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition"
                                >
                                    Delete
                                </button>
                            </form>
                        </>
                    ) : (
                        <>
                            {/* View User's Posts */}
                            <a
                                href={`/${item.id}/posts`}
                                className="text-sm bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition"
                            >
                                View
                            </a>

                            {/* Assign Role */}
                            <a
                                href={`/users/${item.id}/role`}
                                className="text-sm bg-purple-500 text-white px-3 py-1 rounded-md hover:bg-purple-600 transition"
                            >
                                Role
                            </a>

                            {/* Delete User and Their Posts */}
                            <form
                                method="POST"
                                action={`/users/${item.id}`}
                                onSubmit={(e) => {
                                    if (!confirm("Are you sure you want to delete this user and all their posts?")) e.preventDefault();
                                }}
                            >
                                <input type="hidden" name="_method" value="DELETE" />
                                <input type="hidden" name="_token" value={csrf} />
                                <button
                                    type="submit"
                                    className="text-sm bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition"
                                >
                                    Delete
                                </button>
                            </form>
                        </>
                    )}
                </div>

                </div>
            )) : (
                <div className="text-center px-6 py-6 text-gray-600">No {type}s found.</div>
            )}
        </div>
    );
}