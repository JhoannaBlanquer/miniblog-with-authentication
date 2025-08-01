import React, { useState, useEffect } from 'react';
import * as Tabs from '@radix-ui/react-tabs';
import * as Dialog from '@radix-ui/react-dialog';
import * as DropdownMenu from '@radix-ui/react-dropdown-menu';

export default function AdminDashboard() {
    const [openModal, setOpenModal] = useState(false);
    const [posts, setPosts] = useState([]);
    const [userCount, setUserCount] = useState(0);
    const [postCount, setPostCount] = useState(0);

    useEffect(() => {
        if (window.posts) setPosts(window.posts);
        if (window.userCount) setUserCount(window.userCount);
        if (window.postCount) setPostCount(window.postCount);
    }, []);

    const handleLogout = () => {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        }).then(() => {
            window.location.href = '/';
        });
    };

    return (
        <div className="flex flex-col min-h-screen font-sans bg-blue-100 text-gray-900">
            {/* Header */}
            <header className="bg-[#00306D] text-white py-4 shadow-md">
                <div className="container mx-auto px-6 flex justify-between items-center">
                    <h1 className="text-xl font-bold">Admin Dashboard</h1>
                    <div className="flex gap-4">
                        <a href="/" className="bg-white text-[#00306D] px-4 py-2 rounded hover:bg-slate-100 transition">Home</a>
                        <button
                            onClick={handleLogout}
                            className="bg-red-600 px-4 py-2 rounded hover:bg-red-700 transition"
                        >
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            {/* Main content */}
            <main className="flex-1 p-6">
                {/* Summary Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                    <div className="bg-brown-700 text-white p-4 rounded shadow text-center">
                        <h2 className="text-lg font-semibold">Users</h2>
                        <p className="text-2xl">{userCount}</p>
                    </div>
                    <div className="bg-brown-700 text-white p-4 rounded shadow text-center">
                        <h2 className="text-lg font-semibold">Posts</h2>
                        <p className="text-2xl">{postCount}</p>
                    </div>
                    <div className="bg-brown-700 text-white p-4 rounded shadow text-center">
                        <h2 className="text-lg font-semibold">Likes</h2>
                        <p className="text-2xl">0</p>
                    </div>
                    <div className="bg-brown-700 text-white p-4 rounded shadow text-center">
                        <h2 className="text-lg font-semibold">Reports</h2>
                        <p className="text-2xl">0</p>
                    </div>
                </div>

                {/* Tabs Section */}
                <Tabs.Root defaultValue="posts">
                    <Tabs.List className="flex space-x-4 border-b mb-4">
                        <Tabs.Trigger value="posts" className="py-2 px-4">Posts</Tabs.Trigger>
                        <Tabs.Trigger value="users" className="py-2 px-4">Users</Tabs.Trigger>
                    </Tabs.List>

                    <Tabs.Content value="posts">
                        <div className="flex justify-between mb-2">
                            <h2 className="text-xl">All Posts</h2>
                            <Dialog.Root open={openModal} onOpenChange={setOpenModal}>
                                <Dialog.Trigger className="bg-blue-500 text-white px-4 py-2 rounded">New Post</Dialog.Trigger>
                                <Dialog.Portal>
                                    <Dialog.Overlay className="fixed inset-0 bg-black/30" />
                                    <Dialog.Content className="fixed top-[30%] left-1/2 -translate-x-1/2 bg-white p-6 rounded shadow-lg w-[400px]">
                                        <Dialog.Title className="text-lg font-bold mb-2">Create Post</Dialog.Title>
                                        <form method="POST" action="/posts">
                                            <input
                                                type="hidden"
                                                name="_token"
                                                value={document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                                            />
                                            <input type="text" name="title" placeholder="Title" className="w-full mb-2 border p-2" />
                                            <textarea name="content" placeholder="Content" className="w-full mb-2 border p-2"></textarea>
                                            <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded">Save</button>
                                        </form>

                                        <Dialog.Close className="absolute top-2 right-2">×</Dialog.Close>
                                    </Dialog.Content>
                                </Dialog.Portal>
                            </Dialog.Root>
                        </div>

                        {/* Posts Table */}
                        <div className="bg-white rounded shadow overflow-hidden">
                            <div className="grid grid-cols-3 font-bold bg-gray-200 px-4 py-2 border-b">
                                <div>ID</div>
                                <div>Title</div>
                                <div className="text-right">Actions</div>
                            </div>

                            {posts.length > 0 ? (
                                posts.map((post) => (
                                    <div key={post.id} className="grid grid-cols-3 items-center px-4 py-3 border-b">
                                        <div>{post.id}</div>
                                        <div>{post.title}</div>
                                        <div className="flex justify-end space-x-2">
                                            <a
                                                href={`/posts/${post.id}`}
                                                className="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                            >
                                                Read More
                                            </a>
                                            <a
                                                href={`/posts/${post.id}/edit`}
                                                className="text-sm bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                            >
                                                Edit
                                            </a>
                                            <form method="POST" action={`/posts/${post.id}`} onSubmit={(e) => {
                                                if (!confirm('Are you sure you want to delete this post?')) e.preventDefault();
                                            }}>
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').content} />
                                                <button
                                                    type="submit"
                                                    className="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="px-4 py-3 text-gray-600">No posts found.</div>
                            )}
                        </div>
                    </Tabs.Content>

                    <Tabs.Content value="users">
                        <h2 className="text-xl mb-2">User Management</h2>
                        <DropdownMenu.Root>
                            <DropdownMenu.Trigger className="bg-gray-700 text-white px-4 py-2 rounded">Actions</DropdownMenu.Trigger>
                            <DropdownMenu.Portal>
                                <DropdownMenu.Content className="bg-white p-2 shadow rounded w-48">
                                    <DropdownMenu.Item className="p-2 hover:bg-gray-100">Add User</DropdownMenu.Item>
                                    <DropdownMenu.Item className="p-2 hover:bg-gray-100">Assign Role</DropdownMenu.Item>
                                </DropdownMenu.Content>
                            </DropdownMenu.Portal>
                        </DropdownMenu.Root>
                    </Tabs.Content>
                </Tabs.Root>
            </main>

            {/* Footer */}
            <footer className="bg-[#00306D] text-white text-center py-4 text-sm mt-6">
                &copy; {new Date().getFullYear()} WonderWhere. All rights reserved.
            </footer>
        </div>
    );
}