<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class tbl_certificado_vacinaPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Tbl Certificado Vacina');
            $this->SetMenuLabel('Tbl Certificado Vacina');
    
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_certificado_vacina`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_certificado', true, true, true),
                    new IntegerField('animal', true),
                    new IntegerField('campanha', true),
                    new StringField('local_aplicacao', true),
                    new DateField('data_aplicacao')
                )
            );
            $this->dataset->AddLookupField('animal', 'tbl_animal', new IntegerField('id_animal'), new StringField('cpf_proprietario', false, false, false, false, 'animal_cpf_proprietario', 'animal_cpf_proprietario_tbl_animal'), 'animal_cpf_proprietario_tbl_animal');
            $this->dataset->AddLookupField('campanha', 'tbl_campanha_vacinacao', new IntegerField('id_campanha'), new StringField('nome_campanha', false, false, false, false, 'campanha_nome_campanha', 'campanha_nome_campanha_tbl_campanha_vacinacao'), 'campanha_nome_campanha_tbl_campanha_vacinacao');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id_certificado', 'id_certificado', 'Id Certificado'),
                new FilterColumn($this->dataset, 'animal', 'animal_cpf_proprietario', 'Animal'),
                new FilterColumn($this->dataset, 'campanha', 'campanha_nome_campanha', 'Campanha'),
                new FilterColumn($this->dataset, 'local_aplicacao', 'local_aplicacao', 'Local Aplicacao'),
                new FilterColumn($this->dataset, 'data_aplicacao', 'data_aplicacao', 'Data Aplicacao')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_certificado'])
                ->addColumn($columns['animal'])
                ->addColumn($columns['campanha'])
                ->addColumn($columns['local_aplicacao'])
                ->addColumn($columns['data_aplicacao']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('animal')
                ->setOptionsFor('campanha')
                ->setOptionsFor('data_aplicacao');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_certificado_edit');
            
            $filterBuilder->addColumn(
                $columns['id_certificado'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('animal_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tbl_certificado_vacina_animal_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('animal', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tbl_certificado_vacina_animal_search');
            
            $text_editor = new TextEdit('animal');
            
            $filterBuilder->addColumn(
                $columns['animal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('campanha_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tbl_certificado_vacina_campanha_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('campanha', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tbl_certificado_vacina_campanha_search');
            
            $text_editor = new TextEdit('campanha');
            
            $filterBuilder->addColumn(
                $columns['campanha'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('local_aplicacao_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['local_aplicacao'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('data_aplicacao_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['data_aplicacao'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id_certificado field
            //
            $column = new NumberViewColumn('id_certificado', 'id_certificado', 'Id Certificado', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for cpf_proprietario field
            //
            $column = new TextViewColumn('animal', 'animal_cpf_proprietario', 'Animal', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nome_campanha field
            //
            $column = new TextViewColumn('campanha', 'campanha_nome_campanha', 'Campanha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for local_aplicacao field
            //
            $column = new TextViewColumn('local_aplicacao', 'local_aplicacao', 'Local Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for data_aplicacao field
            //
            $column = new DateTimeViewColumn('data_aplicacao', 'data_aplicacao', 'Data Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_certificado field
            //
            $column = new NumberViewColumn('id_certificado', 'id_certificado', 'Id Certificado', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cpf_proprietario field
            //
            $column = new TextViewColumn('animal', 'animal_cpf_proprietario', 'Animal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nome_campanha field
            //
            $column = new TextViewColumn('campanha', 'campanha_nome_campanha', 'Campanha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for local_aplicacao field
            //
            $column = new TextViewColumn('local_aplicacao', 'local_aplicacao', 'Local Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for data_aplicacao field
            //
            $column = new DateTimeViewColumn('data_aplicacao', 'data_aplicacao', 'Data Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for animal field
            //
            $editor = new DynamicCombobox('animal_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_animal`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_animal', true, true, true),
                    new StringField('cpf_proprietario', true),
                    new StringField('nome_proprietario', true),
                    new StringField('contato_principal', true),
                    new StringField('contato_secndario'),
                    new IntegerField('endereco', true),
                    new StringField('nome_animal'),
                    new StringField('especie'),
                    new StringField('raca'),
                    new StringField('sexo'),
                    new StringField('porte'),
                    new DateField('data_nascimento')
                )
            );
            $lookupDataset->setOrderByField('cpf_proprietario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Animal', 'animal', 'animal_cpf_proprietario', 'edit_tbl_certificado_vacina_animal_search', $editor, $this->dataset, $lookupDataset, 'id_animal', 'cpf_proprietario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for campanha field
            //
            $editor = new DynamicCombobox('campanha_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_campanha_vacinacao`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_campanha', true, true, true),
                    new StringField('nome_campanha', true),
                    new IntegerField('vacina', true),
                    new DateField('data_inicio', true),
                    new DateField('data_fim', true),
                    new StringField('orgao_resposavel')
                )
            );
            $lookupDataset->setOrderByField('nome_campanha', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campanha', 'campanha', 'campanha_nome_campanha', 'edit_tbl_certificado_vacina_campanha_search', $editor, $this->dataset, $lookupDataset, 'id_campanha', 'nome_campanha', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for local_aplicacao field
            //
            $editor = new TextEdit('local_aplicacao_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Local Aplicacao', 'local_aplicacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for data_aplicacao field
            //
            $editor = new DateTimeEdit('data_aplicacao_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Data Aplicacao', 'data_aplicacao', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for animal field
            //
            $editor = new DynamicCombobox('animal_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_animal`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_animal', true, true, true),
                    new StringField('cpf_proprietario', true),
                    new StringField('nome_proprietario', true),
                    new StringField('contato_principal', true),
                    new StringField('contato_secndario'),
                    new IntegerField('endereco', true),
                    new StringField('nome_animal'),
                    new StringField('especie'),
                    new StringField('raca'),
                    new StringField('sexo'),
                    new StringField('porte'),
                    new DateField('data_nascimento')
                )
            );
            $lookupDataset->setOrderByField('cpf_proprietario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Animal', 'animal', 'animal_cpf_proprietario', 'multi_edit_tbl_certificado_vacina_animal_search', $editor, $this->dataset, $lookupDataset, 'id_animal', 'cpf_proprietario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for campanha field
            //
            $editor = new DynamicCombobox('campanha_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_campanha_vacinacao`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_campanha', true, true, true),
                    new StringField('nome_campanha', true),
                    new IntegerField('vacina', true),
                    new DateField('data_inicio', true),
                    new DateField('data_fim', true),
                    new StringField('orgao_resposavel')
                )
            );
            $lookupDataset->setOrderByField('nome_campanha', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campanha', 'campanha', 'campanha_nome_campanha', 'multi_edit_tbl_certificado_vacina_campanha_search', $editor, $this->dataset, $lookupDataset, 'id_campanha', 'nome_campanha', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for local_aplicacao field
            //
            $editor = new TextEdit('local_aplicacao_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Local Aplicacao', 'local_aplicacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for data_aplicacao field
            //
            $editor = new DateTimeEdit('data_aplicacao_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Data Aplicacao', 'data_aplicacao', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for animal field
            //
            $editor = new DynamicCombobox('animal_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_animal`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_animal', true, true, true),
                    new StringField('cpf_proprietario', true),
                    new StringField('nome_proprietario', true),
                    new StringField('contato_principal', true),
                    new StringField('contato_secndario'),
                    new IntegerField('endereco', true),
                    new StringField('nome_animal'),
                    new StringField('especie'),
                    new StringField('raca'),
                    new StringField('sexo'),
                    new StringField('porte'),
                    new DateField('data_nascimento')
                )
            );
            $lookupDataset->setOrderByField('cpf_proprietario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Animal', 'animal', 'animal_cpf_proprietario', 'insert_tbl_certificado_vacina_animal_search', $editor, $this->dataset, $lookupDataset, 'id_animal', 'cpf_proprietario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for campanha field
            //
            $editor = new DynamicCombobox('campanha_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_campanha_vacinacao`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_campanha', true, true, true),
                    new StringField('nome_campanha', true),
                    new IntegerField('vacina', true),
                    new DateField('data_inicio', true),
                    new DateField('data_fim', true),
                    new StringField('orgao_resposavel')
                )
            );
            $lookupDataset->setOrderByField('nome_campanha', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Campanha', 'campanha', 'campanha_nome_campanha', 'insert_tbl_certificado_vacina_campanha_search', $editor, $this->dataset, $lookupDataset, 'id_campanha', 'nome_campanha', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for local_aplicacao field
            //
            $editor = new TextEdit('local_aplicacao_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Local Aplicacao', 'local_aplicacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for data_aplicacao field
            //
            $editor = new DateTimeEdit('data_aplicacao_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Data Aplicacao', 'data_aplicacao', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id_certificado field
            //
            $column = new NumberViewColumn('id_certificado', 'id_certificado', 'Id Certificado', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cpf_proprietario field
            //
            $column = new TextViewColumn('animal', 'animal_cpf_proprietario', 'Animal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nome_campanha field
            //
            $column = new TextViewColumn('campanha', 'campanha_nome_campanha', 'Campanha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for local_aplicacao field
            //
            $column = new TextViewColumn('local_aplicacao', 'local_aplicacao', 'Local Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for data_aplicacao field
            //
            $column = new DateTimeViewColumn('data_aplicacao', 'data_aplicacao', 'Data Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_certificado field
            //
            $column = new NumberViewColumn('id_certificado', 'id_certificado', 'Id Certificado', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for cpf_proprietario field
            //
            $column = new TextViewColumn('animal', 'animal_cpf_proprietario', 'Animal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nome_campanha field
            //
            $column = new TextViewColumn('campanha', 'campanha_nome_campanha', 'Campanha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for local_aplicacao field
            //
            $column = new TextViewColumn('local_aplicacao', 'local_aplicacao', 'Local Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for data_aplicacao field
            //
            $column = new DateTimeViewColumn('data_aplicacao', 'data_aplicacao', 'Data Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for cpf_proprietario field
            //
            $column = new TextViewColumn('animal', 'animal_cpf_proprietario', 'Animal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nome_campanha field
            //
            $column = new TextViewColumn('campanha', 'campanha_nome_campanha', 'Campanha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for local_aplicacao field
            //
            $column = new TextViewColumn('local_aplicacao', 'local_aplicacao', 'Local Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for data_aplicacao field
            //
            $column = new DateTimeViewColumn('data_aplicacao', 'data_aplicacao', 'Data Aplicacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_animal`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_animal', true, true, true),
                    new StringField('cpf_proprietario', true),
                    new StringField('nome_proprietario', true),
                    new StringField('contato_principal', true),
                    new StringField('contato_secndario'),
                    new IntegerField('endereco', true),
                    new StringField('nome_animal'),
                    new StringField('especie'),
                    new StringField('raca'),
                    new StringField('sexo'),
                    new StringField('porte'),
                    new DateField('data_nascimento')
                )
            );
            $lookupDataset->setOrderByField('cpf_proprietario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_tbl_certificado_vacina_animal_search', 'id_animal', 'cpf_proprietario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_campanha_vacinacao`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_campanha', true, true, true),
                    new StringField('nome_campanha', true),
                    new IntegerField('vacina', true),
                    new DateField('data_inicio', true),
                    new DateField('data_fim', true),
                    new StringField('orgao_resposavel')
                )
            );
            $lookupDataset->setOrderByField('nome_campanha', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_tbl_certificado_vacina_campanha_search', 'id_campanha', 'nome_campanha', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_animal`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_animal', true, true, true),
                    new StringField('cpf_proprietario', true),
                    new StringField('nome_proprietario', true),
                    new StringField('contato_principal', true),
                    new StringField('contato_secndario'),
                    new IntegerField('endereco', true),
                    new StringField('nome_animal'),
                    new StringField('especie'),
                    new StringField('raca'),
                    new StringField('sexo'),
                    new StringField('porte'),
                    new DateField('data_nascimento')
                )
            );
            $lookupDataset->setOrderByField('cpf_proprietario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_tbl_certificado_vacina_animal_search', 'id_animal', 'cpf_proprietario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_campanha_vacinacao`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_campanha', true, true, true),
                    new StringField('nome_campanha', true),
                    new IntegerField('vacina', true),
                    new DateField('data_inicio', true),
                    new DateField('data_fim', true),
                    new StringField('orgao_resposavel')
                )
            );
            $lookupDataset->setOrderByField('nome_campanha', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_tbl_certificado_vacina_campanha_search', 'id_campanha', 'nome_campanha', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_animal`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_animal', true, true, true),
                    new StringField('cpf_proprietario', true),
                    new StringField('nome_proprietario', true),
                    new StringField('contato_principal', true),
                    new StringField('contato_secndario'),
                    new IntegerField('endereco', true),
                    new StringField('nome_animal'),
                    new StringField('especie'),
                    new StringField('raca'),
                    new StringField('sexo'),
                    new StringField('porte'),
                    new DateField('data_nascimento')
                )
            );
            $lookupDataset->setOrderByField('cpf_proprietario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_tbl_certificado_vacina_animal_search', 'id_animal', 'cpf_proprietario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_campanha_vacinacao`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_campanha', true, true, true),
                    new StringField('nome_campanha', true),
                    new IntegerField('vacina', true),
                    new DateField('data_inicio', true),
                    new DateField('data_fim', true),
                    new StringField('orgao_resposavel')
                )
            );
            $lookupDataset->setOrderByField('nome_campanha', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_tbl_certificado_vacina_campanha_search', 'id_campanha', 'nome_campanha', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_animal`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_animal', true, true, true),
                    new StringField('cpf_proprietario', true),
                    new StringField('nome_proprietario', true),
                    new StringField('contato_principal', true),
                    new StringField('contato_secndario'),
                    new IntegerField('endereco', true),
                    new StringField('nome_animal'),
                    new StringField('especie'),
                    new StringField('raca'),
                    new StringField('sexo'),
                    new StringField('porte'),
                    new DateField('data_nascimento')
                )
            );
            $lookupDataset->setOrderByField('cpf_proprietario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_tbl_certificado_vacina_animal_search', 'id_animal', 'cpf_proprietario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tbl_campanha_vacinacao`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_campanha', true, true, true),
                    new StringField('nome_campanha', true),
                    new IntegerField('vacina', true),
                    new DateField('data_inicio', true),
                    new DateField('data_fim', true),
                    new StringField('orgao_resposavel')
                )
            );
            $lookupDataset->setOrderByField('nome_campanha', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_tbl_certificado_vacina_campanha_search', 'id_campanha', 'nome_campanha', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new tbl_certificado_vacinaPage("tbl_certificado_vacina", "tbl_certificado_vacina.php", GetCurrentUserPermissionsForPage("tbl_certificado_vacina"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("tbl_certificado_vacina"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
