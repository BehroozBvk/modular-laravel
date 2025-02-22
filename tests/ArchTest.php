<?php

arch()->preset()->Laravel();

arch()->test(
    'Admin model should be in the Admin namespace',
    function () {
        assertModelNamespace(Admin::class, 'Admin');
    }
);
