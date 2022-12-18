<if:{$modifications}>
    <div class="modifications" data-goods="{$viewgoods}"> 
        <div class="overlay" style="display:none;"></div>
        <repeat:modifications_group name=mgroup>
            <div class="groupFeature" data-id="[mgroup.id]"> 
                <repeat:modifications_feature_[mgroup.id] name=mfeature>
                    <div class="itemFeature <if:[mfeature.type]=='colorlist'>colorFeature</if>" data-id="[mfeature.id]" data-type="[mfeature.type]">
                        <div class="nameFeature">
                            <span class="featureName">[mfeature.name]</span>
                            <noempty:[mfeature.description]>
                                <span class="markDescription">?</span>
                                <div class="contentDescription" style="display:none;">
                                    [mfeature.description]
                                </div>
                            </noempty>                                                                             
                        </div>
                        <if:[param310]=='radio'>
                            <repeat:modifications_value_[mfeature.line] name=mvalue>
                                <label class="itemValue" title="[mvalue.value]" data-id="[mvalue.id]">
                                    <input type="radio" name="feature[<noempty:{$show_page}>s_</noempty>{$viewgoods}_[mgroup.id]_[mfeature.id]]" value="[mvalue.id]" [mvalue.checked]>
                                    <if:[mfeature.type]=='colorlist'>
                                        <if:[mvalue.image] != ''>
                                            <img class="featureValue" src="[mvalue.image]">
                                        <else>
                                            <span class="featureValue" style="background-color:#[mvalue.color];">
                                                <span></span>
                                            </span>
                                        </if>
                                    <else>
                                        <span class="featureValue">[mvalue.value]</span>    
                                    </if>
                                </label>
                            </repeat:modifications_value_[mfeature.line]>
                        <else>
                            <select name="feature[{$viewgoods}_[mgroup.id]_[mfeature.id]]">
                                <repeat:modifications_value_[mfeature.line] name=mvalue>
                                    <option title="[mvalue.value]" data-id="[mvalue.id]" value="[mvalue.id]" [mvalue.checked]>[mvalue.value]</option>
                                </repeat:modifications_value_[mfeature.line]>
                            </select>
                        </if>
                    </div>
                </repeat:modifications_feature_[mgroup.id]>
            </div>
        </repeat:modifications_group>
    </div>   
</if>
