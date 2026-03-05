<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Authentication Routes
$routes->get('signup', 'Auth::signup');
$routes->post('auth/register', 'Auth::register');
$routes->get('signin', 'Auth::signin');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('profile', 'Auth::profile');
$routes->post('auth/updateProfile', 'Auth::updateProfile');
$routes->get('change-password', 'Auth::changePassword');
$routes->post('auth/updatePassword', 'Auth::updatePassword');

// Chat Routes
$routes->get('chat', 'Chat::index');
$routes->post('chat/sendMessage', 'Chat::sendMessage');
$routes->get('chat/getMessages', 'Chat::getMessages');
$routes->get('chat/getNewMessages', 'Chat::getNewMessages');
$routes->post('chat/markAsRead', 'Chat::markAsRead');
$routes->get('chat/getUnreadCount', 'Chat::getUnreadCount');
