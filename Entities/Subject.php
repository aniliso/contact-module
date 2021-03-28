<?php

namespace Modules\Contact\Entities;

class Subject
{
    public function all()
    {
        if ($subjects = setting('contact::contact-subjects')) {
            $subjects = explode(PHP_EOL, $subjects);
            $items = collect($subjects);
            if ($items->count() > 0) {
                foreach ($items as $key => $item) {
                    list($id, $title, $email) = explode(';', $item);
                    $items[$key] = [
                        'id'       => $id,
                        'title'    => $title,
                        'email'    => $email
                    ];
                }
            }
            return $items;
        }
        return collect();
    }

    public function list()
    {
        if ($subjects = $this->all()) {
            return $subjects->map(function ($item) {
                return [
                    'id'       => $item['id'],
                    'title'    => $item['title']
                ];
            });
        }
        return collect();
    }

    public function getSubject($id)
    {
        return $this->all()->where('id', $id)->first();
    }
}