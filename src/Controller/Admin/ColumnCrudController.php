<?php

namespace App\Controller\Admin;

use App\Entity\Column;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ColumnCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Column::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('columnName'),
            TextField::new('comment'),
        ];
    }
}
