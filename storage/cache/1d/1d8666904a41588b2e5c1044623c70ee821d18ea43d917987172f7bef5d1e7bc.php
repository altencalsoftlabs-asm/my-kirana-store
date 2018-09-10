<?php

/* user/user_form.twig */
class __TwigTemplate_05387336b9c9316a4da37539edc846f8ea6f68a99ddc34698a28b56531f0599f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo (isset($context["header"]) ? $context["header"] : null);
        echo (isset($context["column_left"]) ? $context["column_left"] : null);
        echo "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <div class=\"pull-right\">
        <button type=\"submit\" form=\"form-user\" data-toggle=\"tooltip\" title=\"";
        // line 6
        echo (isset($context["button_save"]) ? $context["button_save"] : null);
        echo "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i></button>
        <a href=\"";
        // line 7
        echo (isset($context["cancel"]) ? $context["cancel"] : null);
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo (isset($context["button_cancel"]) ? $context["button_cancel"] : null);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i></a></div>
      <h1>";
        // line 8
        echo (isset($context["heading_title"]) ? $context["heading_title"] : null);
        echo "</h1>
      <ul class=\"breadcrumb\">
        ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["breadcrumbs"]) ? $context["breadcrumbs"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 11
            echo "        <li><a href=\"";
            echo $this->getAttribute($context["breadcrumb"], "href", array());
            echo "\">";
            echo $this->getAttribute($context["breadcrumb"], "text", array());
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "      </ul>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 17
        if ((isset($context["error_warning"]) ? $context["error_warning"] : null)) {
            // line 18
            echo "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo (isset($context["error_warning"]) ? $context["error_warning"] : null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 22
        echo "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\">
        <h3 class=\"panel-title\"><i class=\"fa fa-pencil\"></i> ";
        // line 24
        echo (isset($context["text_form"]) ? $context["text_form"] : null);
        echo "</h3>
      </div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 27
        echo (isset($context["action"]) ? $context["action"] : null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-user\" class=\"form-horizontal\">
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-username\">";
        // line 29
        echo (isset($context["entry_username"]) ? $context["entry_username"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"username\" value=\"";
        // line 31
        echo (isset($context["username"]) ? $context["username"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["entry_username"]) ? $context["entry_username"] : null);
        echo "\" id=\"input-username\" class=\"form-control\" />
              ";
        // line 32
        if ((isset($context["error_username"]) ? $context["error_username"] : null)) {
            // line 33
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_username"]) ? $context["error_username"] : null);
            echo "</div>
              ";
        }
        // line 35
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-user-group\">";
        // line 38
        echo (isset($context["entry_user_group"]) ? $context["entry_user_group"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"user_group_id\" id=\"input-user-group\" class=\"form-control\">
                ";
        // line 41
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["user_groups"]) ? $context["user_groups"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["user_group"]) {
            // line 42
            echo "                ";
            if (($this->getAttribute($context["user_group"], "user_group_id", array()) == (isset($context["user_group_id"]) ? $context["user_group_id"] : null))) {
                // line 43
                echo "                <option value=\"";
                echo $this->getAttribute($context["user_group"], "user_group_id", array());
                echo "\" selected=\"selected\">";
                echo $this->getAttribute($context["user_group"], "name", array());
                echo "</option>
                ";
            } else {
                // line 45
                echo "                <option value=\"";
                echo $this->getAttribute($context["user_group"], "user_group_id", array());
                echo "\">";
                echo $this->getAttribute($context["user_group"], "name", array());
                echo "</option>
                ";
            }
            // line 47
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user_group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 48
        echo "              </select>
            </div>
          </div>
\t\t  <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-user_type_id\">";
        // line 52
        echo (isset($context["entry_user_type"]) ? $context["entry_user_type"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
             <select name=\"user_type_id\" id=\"input-user_type_id\" class=\"form-control\">
                <option value=\"\" selected=\"selected\">----</option>
\t\t\t\t";
        // line 56
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["user_types"]) ? $context["user_types"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["user_type"]) {
            // line 57
            echo "                ";
            if (($this->getAttribute($context["user_type"], "user_type_id", array()) == (isset($context["user_type_id"]) ? $context["user_type_id"] : null))) {
                // line 58
                echo "                <option value=\"";
                echo $this->getAttribute($context["user_type"], "user_type_id", array());
                echo "\" selected=\"selected\">";
                echo $this->getAttribute($context["user_type"], "name", array());
                echo "</option>
                ";
            } else {
                // line 60
                echo "                <option value=\"";
                echo $this->getAttribute($context["user_type"], "user_type_id", array());
                echo "\">";
                echo $this->getAttribute($context["user_type"], "name", array());
                echo "</option>
                ";
            }
            // line 62
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user_type'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        echo "              </select>
              ";
        // line 64
        if ((isset($context["error_user_type_id"]) ? $context["error_user_type_id"] : null)) {
            // line 65
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_user_type_id"]) ? $context["error_user_type_id"] : null);
            echo "</div>
              ";
        }
        // line 67
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-firstname\">";
        // line 70
        echo (isset($context["entry_firstname"]) ? $context["entry_firstname"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"firstname\" value=\"";
        // line 72
        echo (isset($context["firstname"]) ? $context["firstname"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["entry_firstname"]) ? $context["entry_firstname"] : null);
        echo "\" id=\"input-firstname\" class=\"form-control\" />
              ";
        // line 73
        if ((isset($context["error_firstname"]) ? $context["error_firstname"] : null)) {
            // line 74
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_firstname"]) ? $context["error_firstname"] : null);
            echo "</div>
              ";
        }
        // line 76
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-lastname\">";
        // line 79
        echo (isset($context["entry_lastname"]) ? $context["entry_lastname"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"lastname\" value=\"";
        // line 81
        echo (isset($context["lastname"]) ? $context["lastname"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["entry_lastname"]) ? $context["entry_lastname"] : null);
        echo "\" id=\"input-lastname\" class=\"form-control\" />
              ";
        // line 82
        if ((isset($context["error_lastname"]) ? $context["error_lastname"] : null)) {
            // line 83
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_lastname"]) ? $context["error_lastname"] : null);
            echo "</div>
              ";
        }
        // line 85
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-email\">";
        // line 88
        echo (isset($context["entry_email"]) ? $context["entry_email"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"email\" value=\"";
        // line 90
        echo (isset($context["email"]) ? $context["email"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["entry_email"]) ? $context["entry_email"] : null);
        echo "\" id=\"input-email\" class=\"form-control\" />
              ";
        // line 91
        if ((isset($context["error_email"]) ? $context["error_email"] : null)) {
            // line 92
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_email"]) ? $context["error_email"] : null);
            echo "</div>
              ";
        }
        // line 94
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-image\">";
        // line 97
        echo (isset($context["entry_image"]) ? $context["entry_image"] : null);
        echo "</label>
            <div class=\"col-sm-10\"><a href=\"\" id=\"thumb-image\" data-toggle=\"image\" class=\"img-thumbnail\"><img src=\"";
        // line 98
        echo (isset($context["thumb"]) ? $context["thumb"] : null);
        echo "\" alt=\"\" title=\"\" data-placeholder=\"";
        echo (isset($context["placeholder"]) ? $context["placeholder"] : null);
        echo "\" /></a>
              <input type=\"hidden\" name=\"image\" value=\"";
        // line 99
        echo (isset($context["image"]) ? $context["image"] : null);
        echo "\" id=\"input-image\" />
            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-password\">";
        // line 103
        echo (isset($context["entry_password"]) ? $context["entry_password"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"password\" name=\"password\" value=\"";
        // line 105
        echo (isset($context["password"]) ? $context["password"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["entry_password"]) ? $context["entry_password"] : null);
        echo "\" id=\"input-password\" class=\"form-control\" autocomplete=\"off\" />
              ";
        // line 106
        if ((isset($context["error_password"]) ? $context["error_password"] : null)) {
            // line 107
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_password"]) ? $context["error_password"] : null);
            echo "</div>
              ";
        }
        // line 109
        echo "            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-confirm\">";
        // line 112
        echo (isset($context["entry_confirm"]) ? $context["entry_confirm"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"password\" name=\"confirm\" value=\"";
        // line 114
        echo (isset($context["confirm"]) ? $context["confirm"] : null);
        echo "\" placeholder=\"";
        echo (isset($context["entry_confirm"]) ? $context["entry_confirm"] : null);
        echo "\" id=\"input-confirm\" class=\"form-control\" />
              ";
        // line 115
        if ((isset($context["error_confirm"]) ? $context["error_confirm"] : null)) {
            // line 116
            echo "              <div class=\"text-danger\">";
            echo (isset($context["error_confirm"]) ? $context["error_confirm"] : null);
            echo "</div>
              ";
        }
        // line 118
        echo "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-status\">";
        // line 121
        echo (isset($context["entry_status"]) ? $context["entry_status"] : null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"status\" id=\"input-status\" class=\"form-control\">
                ";
        // line 124
        if ((isset($context["status"]) ? $context["status"] : null)) {
            // line 125
            echo "                <option value=\"0\">";
            echo (isset($context["text_disabled"]) ? $context["text_disabled"] : null);
            echo "</option>
                <option value=\"1\" selected=\"selected\">";
            // line 126
            echo (isset($context["text_enabled"]) ? $context["text_enabled"] : null);
            echo "</option>
                ";
        } else {
            // line 128
            echo "                <option value=\"0\" selected=\"selected\">";
            echo (isset($context["text_disabled"]) ? $context["text_disabled"] : null);
            echo "</option>
                <option value=\"1\">";
            // line 129
            echo (isset($context["text_enabled"]) ? $context["text_enabled"] : null);
            echo "</option>
                ";
        }
        // line 131
        echo "              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 139
        echo (isset($context["footer"]) ? $context["footer"] : null);
        echo " ";
    }

    public function getTemplateName()
    {
        return "user/user_form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  381 => 139,  371 => 131,  366 => 129,  361 => 128,  356 => 126,  351 => 125,  349 => 124,  343 => 121,  338 => 118,  332 => 116,  330 => 115,  324 => 114,  319 => 112,  314 => 109,  308 => 107,  306 => 106,  300 => 105,  295 => 103,  288 => 99,  282 => 98,  278 => 97,  273 => 94,  267 => 92,  265 => 91,  259 => 90,  254 => 88,  249 => 85,  243 => 83,  241 => 82,  235 => 81,  230 => 79,  225 => 76,  219 => 74,  217 => 73,  211 => 72,  206 => 70,  201 => 67,  195 => 65,  193 => 64,  190 => 63,  184 => 62,  176 => 60,  168 => 58,  165 => 57,  161 => 56,  154 => 52,  148 => 48,  142 => 47,  134 => 45,  126 => 43,  123 => 42,  119 => 41,  113 => 38,  108 => 35,  102 => 33,  100 => 32,  94 => 31,  89 => 29,  84 => 27,  78 => 24,  74 => 22,  66 => 18,  64 => 17,  58 => 13,  47 => 11,  43 => 10,  38 => 8,  32 => 7,  28 => 6,  19 => 1,);
    }
}
/* {{ header }}{{ column_left }}*/
/* <div id="content">*/
/*   <div class="page-header">*/
/*     <div class="container-fluid">*/
/*       <div class="pull-right">*/
/*         <button type="submit" form="form-user" data-toggle="tooltip" title="{{ button_save }}" class="btn btn-primary"><i class="fa fa-save"></i></button>*/
/*         <a href="{{ cancel }}" data-toggle="tooltip" title="{{ button_cancel }}" class="btn btn-default"><i class="fa fa-reply"></i></a></div>*/
/*       <h1>{{ heading_title }}</h1>*/
/*       <ul class="breadcrumb">*/
/*         {% for breadcrumb in breadcrumbs %}*/
/*         <li><a href="{{ breadcrumb.href }}">{{ breadcrumb.text }}</a></li>*/
/*         {% endfor %}*/
/*       </ul>*/
/*     </div>*/
/*   </div>*/
/*   <div class="container-fluid">*/
/*     {% if error_warning %}*/
/*     <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> {{ error_warning }}*/
/*       <button type="button" class="close" data-dismiss="alert">&times;</button>*/
/*     </div>*/
/*     {% endif %}*/
/*     <div class="panel panel-default">*/
/*       <div class="panel-heading">*/
/*         <h3 class="panel-title"><i class="fa fa-pencil"></i> {{ text_form }}</h3>*/
/*       </div>*/
/*       <div class="panel-body">*/
/*         <form action="{{ action }}" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">*/
/*           <div class="form-group required">*/
/*             <label class="col-sm-2 control-label" for="input-username">{{ entry_username }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="username" value="{{ username }}" placeholder="{{ entry_username }}" id="input-username" class="form-control" />*/
/*               {% if error_username %}*/
/*               <div class="text-danger">{{ error_username }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-user-group">{{ entry_user_group }}</label>*/
/*             <div class="col-sm-10">*/
/*               <select name="user_group_id" id="input-user-group" class="form-control">*/
/*                 {% for user_group in user_groups %}*/
/*                 {% if user_group.user_group_id == user_group_id %}*/
/*                 <option value="{{ user_group.user_group_id }}" selected="selected">{{ user_group.name }}</option>*/
/*                 {% else %}*/
/*                 <option value="{{ user_group.user_group_id }}">{{ user_group.name }}</option>*/
/*                 {% endif %}*/
/*                 {% endfor %}*/
/*               </select>*/
/*             </div>*/
/*           </div>*/
/* 		  <div class="form-group required">*/
/*             <label class="col-sm-2 control-label" for="input-user_type_id">{{ entry_user_type }}</label>*/
/*             <div class="col-sm-10">*/
/*              <select name="user_type_id" id="input-user_type_id" class="form-control">*/
/*                 <option value="" selected="selected">----</option>*/
/* 				{% for user_type in user_types %}*/
/*                 {% if user_type.user_type_id == user_type_id %}*/
/*                 <option value="{{ user_type.user_type_id }}" selected="selected">{{ user_type.name }}</option>*/
/*                 {% else %}*/
/*                 <option value="{{ user_type.user_type_id }}">{{ user_type.name }}</option>*/
/*                 {% endif %}*/
/*                 {% endfor %}*/
/*               </select>*/
/*               {% if error_user_type_id %}*/
/*               <div class="text-danger">{{ error_user_type_id }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group required">*/
/*             <label class="col-sm-2 control-label" for="input-firstname">{{ entry_firstname }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="firstname" value="{{ firstname }}" placeholder="{{ entry_firstname }}" id="input-firstname" class="form-control" />*/
/*               {% if error_firstname %}*/
/*               <div class="text-danger">{{ error_firstname }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group required">*/
/*             <label class="col-sm-2 control-label" for="input-lastname">{{ entry_lastname }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="lastname" value="{{ lastname }}" placeholder="{{ entry_lastname }}" id="input-lastname" class="form-control" />*/
/*               {% if error_lastname %}*/
/*               <div class="text-danger">{{ error_lastname }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group required">*/
/*             <label class="col-sm-2 control-label" for="input-email">{{ entry_email }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="text" name="email" value="{{ email }}" placeholder="{{ entry_email }}" id="input-email" class="form-control" />*/
/*               {% if error_email %}*/
/*               <div class="text-danger">{{ error_email }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-image">{{ entry_image }}</label>*/
/*             <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="{{ thumb }}" alt="" title="" data-placeholder="{{ placeholder }}" /></a>*/
/*               <input type="hidden" name="image" value="{{ image }}" id="input-image" />*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group required">*/
/*             <label class="col-sm-2 control-label" for="input-password">{{ entry_password }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="password" name="password" value="{{ password }}" placeholder="{{ entry_password }}" id="input-password" class="form-control" autocomplete="off" />*/
/*               {% if error_password %}*/
/*               <div class="text-danger">{{ error_password }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group required">*/
/*             <label class="col-sm-2 control-label" for="input-confirm">{{ entry_confirm }}</label>*/
/*             <div class="col-sm-10">*/
/*               <input type="password" name="confirm" value="{{ confirm }}" placeholder="{{ entry_confirm }}" id="input-confirm" class="form-control" />*/
/*               {% if error_confirm %}*/
/*               <div class="text-danger">{{ error_confirm }}</div>*/
/*               {% endif %}*/
/*             </div>*/
/*           </div>*/
/*           <div class="form-group">*/
/*             <label class="col-sm-2 control-label" for="input-status">{{ entry_status }}</label>*/
/*             <div class="col-sm-10">*/
/*               <select name="status" id="input-status" class="form-control">*/
/*                 {% if status %}*/
/*                 <option value="0">{{ text_disabled }}</option>*/
/*                 <option value="1" selected="selected">{{ text_enabled }}</option>*/
/*                 {% else %}*/
/*                 <option value="0" selected="selected">{{ text_disabled }}</option>*/
/*                 <option value="1">{{ text_enabled }}</option>*/
/*                 {% endif %}*/
/*               </select>*/
/*             </div>*/
/*           </div>*/
/*         </form>*/
/*       </div>*/
/*     </div>*/
/*   </div>*/
/* </div>*/
/* {{ footer }} */
