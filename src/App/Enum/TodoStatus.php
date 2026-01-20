<?php

namespace App\Enum;
enum TodoStatus: string
{
    case Pending = 'pending';
    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public  function getIcon(): string
    {
        return match ($this) {
            self::Pending => '<svg width="16" height="16" fill="orange" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                              <circle cx="12" cy="12" r="10" stroke="orange" stroke-width="2" fill="none"/>
                              <line x1="12" y1="12" x2="12" y2="7" stroke="orange" stroke-width="2" stroke-linecap="round"/>
                              <line x1="12" y1="12" x2="17" y2="12" stroke="orange" stroke-width="2" stroke-linecap="round">
                              <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
                              </line></svg>',
            self::InProgress => '<svg width="16" height="16" fill="green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                              <circle cx="12" cy="12" r="10" stroke="green" stroke-width="2" fill="none" stroke-linecap="round" stroke-dasharray="31.4 94.2">
                              <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
                              </circle></svg>',
            self::Completed => '<svg width="16" height="16" fill="blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                              <circle cx="12" cy="12" r="10" stroke="blue" stroke-width="2" fill="none"/>
                              <polyline points="8 12 11 15 17 9" stroke="blue" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            self::Todo => '<svg width="16" height="16" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                              <circle cx="12" cy="12" r="10" stroke="gray" stroke-width="2" fill="none"/></svg>',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Backlog',
            self::Todo => 'Tasks to do',
            self::InProgress => 'Tasks in progress',
            self::Completed => 'Task completed',
            //default => $this->value
        };
    }
}