import React, { useState, useEffect } from 'react';
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

    return (
        <div className="flex flex-col min-h-screen font-sans bg-blue-100 text-gray-900">
            {/* Header */}
            <header className="bg-[#00306D] text-white py-4 shadow-md relative">
                <div className="container mx-auto px-6 flex items-center justify-between relative">
                    <a href="/" className="absolute left-6 text-white hover:underline">Home</a>
                    <div className="mx-auto">
                        <img src="/images/logo.png" alt="Logo" className="h-10 w-auto scale-[3]" />
                    </div>
                    <DropdownMenu.Root>
                        <DropdownMenu.Trigger asChild>
                            <button className="absolute right-6 h-10 w-10 rounded-full overflow-hidden border-2 border-white">
                                <img src="/images/admin.jpg" alt="Profile" className="h-10 w-10 rounded-full object-cover scale-110" />
                            </button>
                        </DropdownMenu.Trigger>
                        <DropdownMenu.Portal>
                            <DropdownMenu.Content className="bg-white text-black rounded shadow-md py-2 w-40" sideOffset={8}>
                                <DropdownMenu.Item onSelect={handleLogout} className="px-4 py-2 cursor-pointer hover:bg-gray-100">Logout</DropdownMenu.Item>
                            </DropdownMenu.Content>
                        </DropdownMenu.Portal>
                    </DropdownMenu.Root>
                </div>
            </header>

            {/* Main */}
            <main className="flex-1 p-6">
                <div className="flex justify-center gap-8 mb-6">
                    <SummaryCard title="Users" count={userCount} />
                    <SummaryCard title="Posts" count={postCount} />
                </div>

                <Tabs.Root defaultValue="posts" className="w-full max-w-5xl mx-auto">
                    <Tabs.List className="flex justify-center space-x-6 border-b mb-6">
                        <TabTrigger value="posts">Posts</TabTrigger>
                        <TabTrigger value="users">Users</TabTrigger>
                    </Tabs.List>

                    <Tabs.Content value="posts">
                        <SectionHeader title="All Posts" buttonLabel="New Post" openModal={setOpenModal} />
                        <NewPostDialog open={openModal} setOpen={setOpenModal} csrf={csrf} />
                        <DataTable data={posts} type="post" csrf={csrf} />
                    </Tabs.Content>

                    <Tabs.Content value="users">
                        <h2 className="text-2xl font-bold text-[#00306D] mb-4">User Management</h2>
                        <AddUserDialog csrf={csrf} />
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
        <div className="bg-[#00306D] text-white p-6 rounded-xl shadow text-center w-40">
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

function SectionHeader({ title, buttonLabel, openModal }) {
    return (
        <div className="flex justify-between mb-4">
            <h2 className="text-2xl font-bold text-[#00306D]">{title}</h2>
            <button onClick={() => openModal(true)} className="bg-blue-600 text-white px-4 py-2 rounded">{buttonLabel}</button>
        </div>
    );
}

function NewPostDialog({ open, setOpen, csrf }) {
    return (
        <Dialog.Root open={open} onOpenChange={setOpen}>
            <Dialog.Portal>
                <Dialog.Overlay className="fixed inset-0 bg-black/30" />
                <Dialog.Content className="fixed top-[30%] left-1/2 -translate-x-1/2 bg-white p-6 rounded shadow-lg w-[400px]">
                    <Dialog.Title className="text-lg font-bold mb-2">Create Post</Dialog.Title>
                    <form method="POST" action="/posts">
                        <input type="hidden" name="_token" value={csrf} />
                        <input type="text" name="title" placeholder="Title" className="w-full mb-2 border p-2" required />
                        <textarea name="content" placeholder="Content" className="w-full mb-2 border p-2" required></textarea>
                        <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded">Save</button>
                    </form>
                    <Dialog.Close className="absolute top-2 right-2 text-lg font-bold cursor-pointer">×</Dialog.Close>
                </Dialog.Content>
            </Dialog.Portal>
        </Dialog.Root>
    );
}

function AddUserDialog({ csrf }) {
    return (
        <Dialog.Root>
            <div className="flex justify-end mb-4">
                <Dialog.Trigger className="bg-[#00306D] text-white px-4 py-2 rounded">Add User</Dialog.Trigger>
            </div>
            <Dialog.Portal>
                <Dialog.Overlay className="fixed inset-0 bg-black/30" />
                <Dialog.Content className="fixed top-[30%] left-1/2 -translate-x-1/2 bg-white p-6 rounded shadow-lg w-[400px]">
                    <Dialog.Title className="text-lg font-bold mb-2">Add New User</Dialog.Title>
                    <form method="POST" action="/users">
                        <input type="hidden" name="_token" value={csrf} />
                        <input type="text" name="name" placeholder="Name" className="w-full mb-2 border p-2" required />
                        <input type="password" name="password" placeholder="Password" className="w-full mb-2 border p-2" required />
                        <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded">Create</button>
                    </form>
                    <Dialog.Close className="absolute top-2 right-2 text-lg font-bold cursor-pointer">×</Dialog.Close>
                </Dialog.Content>
            </Dialog.Portal>
        </Dialog.Root>
    );
}

function DataTable({ data, type, csrf }) {
    const headers = type === 'post' ? ['ID', 'Title'] : ['ID', 'Name'];

    return (
        <div className="bg-white rounded shadow overflow-hidden">
            <div className="grid grid-cols-3 font-bold bg-gray-200 px-4 py-2 border-b">
                {headers.map(header => <div key={header}>{header}</div>)}
                <div className="text-right">Actions</div>
            </div>
            {data.length > 0 ? data.map((item) => (
                <div key={item.id} className="grid grid-cols-3 items-center px-4 py-3 border-b">
                    <div>{item.id}</div>
                    <div>{item.name || item.title}</div>
                    <div className="flex justify-end space-x-2">
                        {type === 'post' && (
                            <>
                                <a href={`/posts/${item.id}`} className="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Read More</a>
                                <a href={`/posts/${item.id}/edit`} className="text-sm bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            </>
                        )}
                        {type === 'user' && (
                            <a href={`/users/${item.id}/edit`} className="text-sm bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                        )}
                        <form method="POST" action={`/${type === 'post' ? 'posts' : 'users'}/${item.id}`} onSubmit={(e) => {
                            if (!confirm(`Are you sure you want to delete this ${type}?`)) e.preventDefault();
                        }}>
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="_token" value={csrf} />
                            <button type="submit" className="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            )) : (
                <div className="text-center px-4 py-6 text-gray-600">No {type}s found.</div>
            )}
        </div>
    );
}